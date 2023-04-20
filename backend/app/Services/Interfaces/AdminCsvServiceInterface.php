<?php

namespace App\Services\Interfaces;

use Illuminate\Http\UploadedFile;

interface AdminCsvServiceInterface
{
    /**
     * CSVファイルを元に配列データを取得する
     *
     * @param UploadedFile $file
     * @return array
     */
    public function importCsv(UploadedFile $file): array;
}