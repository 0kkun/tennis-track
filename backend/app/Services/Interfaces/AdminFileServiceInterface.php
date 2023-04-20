<?php

namespace App\Services\Interfaces;

use Illuminate\Http\UploadedFile;

interface AdminFileServiceInterface
{
    /**
     * ファイルをS3にアップロードする
     *
     * @param UploadedFile $file
     * @return string $filePath
     */
    public function uploadFile(UploadedFile $file): string;
}