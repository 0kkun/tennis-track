<?php

namespace App\Services\Interfaces;

use Symfony\Component\Console\Helper\ProgressBar;

interface TennisScrapingServiceInterface
{
    /**
     * テニスのATPランキングをスクレイピングで取得する
     *
     * @throws \Exception
     * @return array $results, $statusCode
     */
    public function scrapeTennisRanking(ProgressBar $progressBar): array;

    /**
     * テニス選手をスクレイピングで取得する
     *
     * @throws \Exception
     * @return array
     */
    public function scrapeTennisPlayer(ProgressBar $progressBar): array;

    /**
     * テニス選手の詳細データをスクレイピングで取得する
     *
     * @param ProgressBar $progressBar
     * @return array
     */
    public function scrapeTennisPlayerInfo(ProgressBar $progressBar): array;
}
