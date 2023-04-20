<?php

namespace App\Services;

use App\Services\Interfaces\AdminCsvServiceInterface;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use App\Modules\FileUploader;

class AdminCsvService implements AdminCsvServiceInterface
{
    private const S3_PREFIX = '/csv';

    /**
     * @inheritDoc
     */
    public function importCsv(UploadedFile $file): void
    {
        // 名前をつけてS3へアップロード
        $originName = $file->getClientOriginalName();
        $fileName = Carbon::now()->format('Ymd_His') . '.csv';
        $filePath = FileUploader::upload($file, 's3', self::S3_PREFIX, $fileName);
    }
}