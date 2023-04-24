<?php

namespace App\Services\Interfaces;

use Symfony\Component\Console\Helper\ProgressBar;

interface TennisScrapingServiceInterface
{
    /**
     * テニスのATPランキングをスクレイピングで取得する
     *
     * @return array $results, $statusCode
     * @throws \Exception
     */
    public function scrapeTennisRanking(ProgressBar $progressBar): array;

    /**
     * テニス選手をスクレイピングで取得する
     *
     * @return array
     * @throws \Exception
     */
    public function scrapeTennisPlayer(ProgressBar $progressBar): array;
}