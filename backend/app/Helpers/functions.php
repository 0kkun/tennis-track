<?php

use Carbon\Carbon;

if (! function_exists('monthToInt')) {
    /**
     * テキストのmonth ("April"など)を数値に変換するヘルパー関数
     *
     * @param string $monthName
     * @return int|null
     */
    function monthToInt(string $monthName): ?int
    {
        try {
            $month = Carbon::createFromFormat('F', $monthName);

            return (int) $month->format('n');
        } catch (\Exception $e) {
            return null;
        }
    }
}
