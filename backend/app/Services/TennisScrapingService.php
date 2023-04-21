<?php

namespace App\Services;

use App\Services\Interfaces\TennisScrapingServiceInterface;
use Illuminate\Support\Facades\Log;
// NOTE: Goutte\Clientは4.0以降から非推奨となり、以下を代替しての使用が推奨されている
use Symfony\Component\BrowserKit\HttpBrowser as Client;

class TennisScrapingService implements TennisScrapingServiceInterface
{
    /** テニスランキングサイトURL */
    private const TENNIS_RANK_URL = 'https://www.espn.com/tennis/rankings';

    /**
     * @inheritDoc
     */
    public function scrapeTennisRanking(): array
    {
        try {
            Log::info('[テニスランキング] スクレイピング開始');
            $client = new Client();
            $crawler = $client->request('GET', self::TENNIS_RANK_URL);
            $statusCode = $client->getResponse()->getStatusCode();

            if ($statusCode !== 200) {
                throw new \Exception('[Error]: failed to get page');
            }

            $rows = $crawler->filter('tbody.Table__TBODY')
                ->filter('tr')
                ->each(function ($node) {
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
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            throw $e;
        }
    }
}