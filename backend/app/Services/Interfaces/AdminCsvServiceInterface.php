<?php

namespace App\Services\Interfaces;

use Illuminate\Http\UploadedFile;

interface AdminCsvServiceInterface
{
    /**
     * CSVファイルをS3にアップし、配列を取得する
     *
     * @return void
     */
    public function importCsv(UploadedFile $file): void;
}