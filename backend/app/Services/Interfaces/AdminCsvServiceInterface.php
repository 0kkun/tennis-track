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

    public function playerExportCsv();

    /**
     * CSVから選手情報のデータを抽出する
     *
     * @param UploadedFile $file
     * @return array
     */
    public function playerImportCsv(UploadedFile $file): array;
}