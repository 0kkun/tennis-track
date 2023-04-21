<?php

namespace App\Services\Interfaces;

interface TennisScrapingServiceInterface
{
    /**
     * テニスのATPランキングをスクレイピングで取得する
     *
     * @return array $results, $statusCode
     * @throws \Exception
     */
    public function scrapeTennisRanking(): array;
}