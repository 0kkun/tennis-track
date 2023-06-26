<?php

namespace App\Modules;

class HeightConverter
{
    /**
     * feetとinchesをcmに変換する
     *
     * @param int $feet
     * @param int $inches
     * @return float
     */
    public static function convertToCm(int $feet, int $inches): float
    {
        $totalInches = $feet * 12 + $inches;
        $cm = $totalInches * 2.54;

        return $cm;
    }
}
