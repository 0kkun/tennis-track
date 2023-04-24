<?php

namespace App\Services;

use App\Repositories\Interfaces\SportCategoryRepositoryInterface;
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
    private const TENNIS_PLAYER_BASE_URL = 'https://www.espn.com/';
    private const TENNIS_PLAYER_URL = 'https://www.espn.com/tennis/players';

    /**
     * @param Client $client
     */
    public function __construct(
        private Client $client,
        private SportCategoryRepositoryInterface $sportCategoryRepository,
        private Carbon $now,
    )
    {
        $this->client = $client;
        $this->sportCategoryRepository = $sportCategoryRepository;
        $this->now = $now;
    }

    /**
     * @inheritDoc
     */
    public function scrapeTennisRanking(ProgressBar $progressBar): array
    {
        Log::info('テニスランキング - スクレイピング開始');
        $crawler = $this->client->request('GET', self::TENNIS_RANK_URL);
        $statusCode = $this->client->getResponse()->getStatusCode();

        if ($statusCode !== 200) {
            throw new \Exception('[Error]:ページの読み込みに失敗しました.');
        }

        $rows = $crawler->filter('tbody.Table__TBODY')
            ->filter('tr')
            ->each(function ($node) use ($progressBar) {
                $rank = $node->filter('td.rank_column')
                    ->filter('span')
                    ->text();

                $rankChange = $node->filter('td.trend')
                    ->text();

                $country = $node->filter('td')
                    ->eq(2)
                    ->filter('img')
                    ->attr('title');

                $name = $node->filter('td')
                    ->eq(2)
                    ->filter('a')
                    ->text();

                $playerLink = $node->filter('td')
                    ->eq(2)
                    ->filter('a')
                    ->attr('href');

                $currentPoint = $node->filter('td')
                    ->eq(3)
                    ->text();

                $age = $node->filter('td')
                    ->eq(4)
                    ->text();

                $progressBar->advance(1);

                return [
                    'current_rank' => $rank,
                    'rank_change' => $rankChange,
                    'country' => $country,
                    'name_en' => $name,
                    'player_link' => $playerLink,
                    'current_point' => $currentPoint,
                    'age' => $age,
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

                if ($node->filter('td')->eq(1)->count()) {
                    $country = $node->filter('td')->eq(1)->text();
                }
                $progressBar->advance(1);

                return [
                    'name_en' => $name,
                    'link' => $link,
                    'country' => $country,
                    'sport_category_id' => $sportCategoryId,
                    'updated_at' => $this->now,
                    'created_at' => $this->now,
                ];
            });
    }
}