<?php

namespace App\Services;

use App\Models\TennisAtpRanking;
use App\Modules\CharacterConverter;
use App\Modules\HeightConverter;
use App\Models\Player;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Repositories\Interfaces\SportCategoryRepositoryInterface;
use App\Repositories\Interfaces\TennisAtpRankingRepositoryInterface;
use App\Services\Interfaces\TennisScrapingServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Helper\ProgressBar;
// NOTE: Goutte\Clientは4.0以降から非推奨となり、以下を代替しての使用が推奨されている
use Symfony\Component\BrowserKit\HttpBrowser as Client;
use Symfony\Component\DomCrawler\Crawler;

class TennisScrapingService implements TennisScrapingServiceInterface
{
    /** テニスランキングサイトURL */
    private const TENNIS_RANK_URL = 'https://www.espn.com/tennis/rankings';
    private const TENNIS_PLAYER_BASE_URL = 'https://www.espn.com';
    private const TENNIS_PLAYER_URL = 'https://www.espn.com/tennis/players';

    /**
     * @param Client $client
     * @param SportCategoryRepositoryInterface $sportCategoryRepository
     * @param Carbon $now
     * @param PlayerRepositoryInterface $playerRepository
     * @param TennisAtpRankingRepositoryInterface $tennisAtpRankingRepository
     */
    public function __construct(
        private Client $client,
        private SportCategoryRepositoryInterface $sportCategoryRepository,
        private Carbon $now,
        private PlayerRepositoryInterface $playerRepository,
        private TennisAtpRankingRepositoryInterface $tennisAtpRankingRepository,
    )
    {
        $this->client = $client;
        $this->sportCategoryRepository = $sportCategoryRepository;
        $this->now = $now;
        $this->playerRepository = $playerRepository;
        $this->tennisAtpRankingRepository = $tennisAtpRankingRepository;
    }

    /**
     * @inheritDoc
     */
    public function scrapeTennisRanking(ProgressBar $progressBar): array
    {
        $progressBar->start();
        Log::info('テニスランキング - スクレイピング開始');
        $crawler = $this->client->request('GET', self::TENNIS_RANK_URL);
        $statusCode = $this->client->getResponse()->getStatusCode();

        if ($statusCode !== 200) {
            throw new \Exception('[Error]:ページの読み込みに失敗しました.');
        }

        $latestTennisRanking = $this->tennisAtpRankingRepository->getLatestUpdatedRecord();
        $lastUpdatedText = $crawler->filter('p.rankings__specialNote')->text();
        $lastUpdated = $this->convertLastUpdatedDate($lastUpdatedText);

        // テーブル内のランキングが既に最新なら処理を行わない
        if (!$this->isRankingAlreadyNew($latestTennisRanking, $lastUpdated)) return [];

        $sportCategoryId = $this->sportCategoryRepository->getIdByName('テニス');
        $tennisPlayers = $this->playerRepository->fetchBySportCategoryId($sportCategoryId)->toArray();
        $tennisPlayers = array_column($tennisPlayers, 'id', 'name_en');

        $rows = $crawler->filter('tbody.Table__TBODY tr')
            ->each(function ($node) use ($progressBar, $tennisPlayers, $sportCategoryId, $lastUpdated) {
                if ($node->count() === 0) throw new \Exception('[Error:] nodeが取得できませんでした.');

                $name = $node->filter('td')
                    ->eq(2)
                    ->filter('a')
                    ->text();

                // チェック文字を変換する
                $name = CharacterConverter::convertToAlphabet($name);

                // 選手が存在しない場合はplayersに新規レコード生成
                if (!isset($tennisPlayers[$name])) {
                    Log::info('存在しない選手がいたため新規選手登録開始: ' . $name);
                    $country = $node->filter('td')
                        ->eq(2)
                        ->filter('img')
                        ->attr('title');

                    // チェック文字を変換する
                    $country = CharacterConverter::convertToAlphabet($country);

                    $playerLink = $node->filter('td')
                        ->eq(2)
                        ->filter('a')
                        ->attr('href');

                    $playerCreateParams = $this->makePlayerCreateParams($name, $playerLink, $country, $sportCategoryId);
                    $playerId = $this->playerRepository->create($playerCreateParams);
                } else {
                    $playerId = $tennisPlayers[$name];
                }

                $rank = $node->filter('td.rank_column')
                    ->filter('span')
                    ->text();

                $rankChange = $node->filter('td')->eq(1)->text();
                if ($rankChange === '-') $rankChange = 0;
                $rankChangeNegative = $node->filter('td')->eq(1)->filter('div.negative');
                if ($rankChangeNegative->count() > 0) $rankChange = '-' . $rankChange;

                $currentPoint = $node->filter('td')
                    ->eq(3)
                    ->text();

                $progressBar->advance(1);

                // FIXME: 更新の場合もcreated_atが更新されてしまう
                return [
                    'current_rank' => intval($rank),
                    'rank_change' => intval($rankChange),
                    'current_point' => intval(str_replace(',', '', $currentPoint)),
                    'player_id' => $playerId,
                    'updated_ymd' => $lastUpdated,
                    'updated_at' => $this->now,
                    'created_at' => $this->now,
                ];
            });
        Log::info('[テニスランキング] ' . count($rows) . '件取得完了.');
        return $rows;
    }

    /**
     * @inheritDoc
     */
    public function scrapeTennisPlayer(ProgressBar $progressBar): array
    {
        $progressBar->start();
        Log::info('テニス選手 - スクレイピング開始');
        $sportCategoryId = $this->sportCategoryRepository->getIdByName('テニス');
        if (!$sportCategoryId) throw new \Exception('[Error]:テニスのカテゴリーIDがテーブルに存在しません.');

        $crawler = $this->client->request('GET', self::TENNIS_PLAYER_URL);
        $statusCode = $this->client->getResponse()->getStatusCode();
        if ($statusCode !== 200) throw new \Exception('[Error]:ページの読み込みに失敗しました.');

        $results = [];
        $tags = ['#my-players-table tr.oddrow', '#my-players-table tr.evenrow'];

        foreach ($tags as $tag) {
            $rows = $this->scrapeRows($crawler, $tag, $sportCategoryId, $progressBar);
            $results = array_merge($results, $rows);
        }
        if (count($results) < 7000) return [];
        return $results;
    }

    /**
     * @inheritDoc
     */
    public function scrapeTennisPlayerInfo(ProgressBar $progressBar): array
    {
        $progressBar->start();
        Log::info('テニス選手詳細 - スクレイピング開始');
        $atpRankings = $this->tennisAtpRankingRepository->fetchWithPlayerByParams();

        $scrapedPlayers = [];

        foreach ($atpRankings as $atpRanking) {
            $crawler = $this->client->request('GET', $atpRanking->player->link);
            $statusCode = $this->client->getResponse()->getStatusCode();
            if ($statusCode !== 200) throw new \Exception('[Error]:ページの読み込みに失敗しました.');

            $rows = $crawler->filter('#content div.mod-container div.player-bio')
                ->each(function ($node) use ($progressBar, $atpRanking) {
                    if ($node->count() === 0) throw new \Exception('[Error:] nodeが取得できませんでした.');

                    $row = [];
                    for ($i=0; $i <= 4; $i++) {
                        if ($node->filter('ul.general-info li')->eq($i)->count()) {
                            $row[] = $node->filter('ul.general-info li')->eq($i)->text();
                        }
                        if ($node->filter('ul.player-metadata li')->eq($i)->count()) {
                            $row[] = $node->filter('ul.player-metadata li')->eq($i)->text();
                        }
                    }

                    $result = $this->mapScrapedData($row);

                    $progressBar->advance(1);

                    return [
                        'id' => $atpRanking->player->id,
                        'name_en' => $atpRanking->player->name_en,
                        'country' => $atpRanking->player->country,
                        'sport_category_id' => $atpRanking->player->sport_category_id,
                        'dominant_arm' => !is_null($result['dominant_arm']) ? Player::getDominantArmInt(str_replace('Plays: ', '', $result['dominant_arm']))  : null,
                        'turn_to_pro_year' => !is_null($result['turn_to_pro_year']) ? str_replace('Turned Pro: ', '', $result['turn_to_pro_year']) : null,
                        'birthday' => !is_null($result['birthday']) ? $this->convertFormattedDate($result['birthday']) : null,
                        'height' => !is_null($result['height']) ? $this->convertHeightToCm($result['height']) : null,
                        'weight' => !is_null($result['weight']) ? $this->convertWeightToKg($result['weight']) : null,
                        'updated_at' => $this->now,
                    ];
                });
            $scrapedPlayers = array_merge($scrapedPlayers, $rows);
        }
        return $scrapedPlayers;
    }

    /**
     * 1つのタグに対して、行をスクレイピングして配列で返す
     *
     * @param Crawler $crawler
     * @param string $tag
     * @param integer $sportCategoryId
     * @param ProgressBar $progressBar
     * @return array
     */
    private function scrapeRows(Crawler $crawler, string $tag, int $sportCategoryId, ProgressBar $progressBar): array
    {
        return $crawler->filter($tag)
            ->each(function ($node) use ($progressBar, $sportCategoryId) {
                $name = null;
                $link = null;
                $country = null;
                if ($node->filter('td')->eq(0)->count()) {
                    $name = $node->filter('td')->eq(0)->text();
                    $link = self::TENNIS_PLAYER_BASE_URL . $node->filter('td')->eq(0)->filter('a')->attr('href');
                }
                // 名前が取得できないなら登録しない
                if (is_null($name)) {
                    return;
                }

                // UTF-8にエンコード
                $name = mb_convert_encoding($name, 'UTF-8', 'auto');

                if ($node->filter('td')->eq(1)->count()) {
                    $country = $node->filter('td')->eq(1)->text();
                    if (is_null($country)) $country = mb_convert_encoding($country, 'UTF-8', 'auto');
                }
                $progressBar->advance(1);

                return $this->makePlayerCreateParams($name, $link, $country, $sportCategoryId);
            });
    }

    /**
     * playersテーブル保存用の配列を作成する
     *
     * @param string $name
     * @param string $country
     * @param string $playerLink
     * @param integer $sportCategoryId
     * @return array
     */
    private function makePlayerCreateParams(string $name, string $playerLink, string $country, int $sportCategoryId): array
    {
        return [
            'name_en' => $name,
            'country' => $country,
            'link' => $playerLink,
            'sport_category_id' => $sportCategoryId,
            'updated_at' => $this->now,
            'created_at' => $this->now,
        ];
    }

    /**
     * 更新日情報をテーブル保存用の形式に変換する
     *
     * @param string $lastUpdatedText
     * @return string
     */
    private function convertLastUpdatedDate(string $lastUpdatedText): string
    {
        $lastUpdated = explode(" ", $lastUpdatedText);
        // ヘルパー関数を使用してテキストの月を数値に変換
        $month = monthToInt($lastUpdated[2]);
        $date = rtrim($lastUpdated[3], ",");
        $year = $lastUpdated[4];
        return Carbon::create($year, $month, $date)->format('Y-m-d');
    }

    /**
     * スクレイピングしてきた更新日を比較し、最新かどうかチェックする
     *
     * @param TennisAtpRanking|null $latestTennisRanking
     * @param string $lastUpdated
     * @return boolean
     */
    private function isRankingAlreadyNew(?TennisAtpRanking $latestTennisRanking, string $lastUpdated): bool
    {
        // テーブル内にランキングがそもそも存在しないならスクレイピングしたものは最新である
        if (!isset($latestTennisRanking->updated_ymd)) return true;
        // テーブル内のランキング更新日とスクレイピングした更新日が違うなら最新である
        if ($latestTennisRanking->updated_ymd !== $lastUpdated) return true;
        else return false;
    }

    /**
     * 「5-10」のようにインチとフィードで表記された単位をcmに変換する
     *
     * @param string $height
     * @return integer
     */
    private function convertHeightToCm(?string $height)
    {
        if (is_null($height)) return null;
        preg_match('/(\d+)-(\d+)/', $height, $matches);
        $feet = $matches[1];
        $inch = $matches[2];
        return HeightConverter::convertToCm($feet, $inch);
    }

    /**
     * 余計な文字を省きつつ生年月日を日付フォーマットにする
     *
     * @param string $text
     * @return string
     */
    private function convertFormattedDate(?string $text): string|null
    {
        if (is_null($text)) return null;
        $matches = [];
        // 余計な文字を削除
        $text = str_replace('Birth Date', '', $text);
        preg_match('/(\w+\s+\d+,\s+\d+)/', $text, $matches);
        $dateString = $matches[1]; // 'December 29, 1989 の形'
        return Carbon::createFromFormat('F j, Y', $dateString)->format('Y-m-d');
    }

    /**
     * 数値だけを抽出しlbsからkgへ変換する
     *
     * @param string|null $text
     * @return string|null
     */
    private function convertWeightToKg(?string $text): string|null
    {
        if (is_null($text)) return null;
        // 正規表現で数字だけを抽出する
        preg_match('/\d+/', $text, $matches);
        $weight = (int)$matches[0];
        // lbsからkgに変換する
        $weightKg = $weight * 0.453592;
        // 2桁まで表示する
        $weightKg = round($weightKg, 2);
        return $weightKg;
    }

    /**
     * スクレイピングしたデータをキーワードに基づいてマッピングした配列を作成する
     *
     * @param array $rows The scraped data to be arranged.
     * @return array The arranged data in the form of an associative array.
     */
    private function mapScrapedData(array $rows): array
    {
        $keywords = [
            'Plays',
            'Turned Pro',
            'Birth Date',
            'Height',
            'Weight',
        ];

        $keys = [
            'dominant_arm',
            'turn_to_pro_year',
            'birthday',
            'height',
            'weight',
        ];

        // キーを設定しつつvalueをnullにして配列を生成する
        $result = array_combine($keys, array_fill(0, count($keys), null));
        foreach ($rows as $row) {
            foreach ($keywords as $index => $keyword) {
                if ($this->isContainText($keyword, $row)) {
                    $result[$keys[$index]] = $row;
                }
            }
        }
        return $result;
    }

    /**
     * 特定のキーワードが含まれるかどうか判定する
     *
     * @param string $keyword
     * @param string|null $targetText
     * @return boolean
     */
    private function isContainText(string $keyword, ?string $targetText): bool
    {
        return strpos($targetText, $keyword) !== false;
    }
}
