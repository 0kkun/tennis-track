<?php

namespace App\Services;

use App\Services\Interfaces\AdminFileServiceInterface;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use App\Modules\FileUploader;

class AdminFileService implements AdminFileServiceInterface
{
    private const S3_PREFIX = '/files';

    /**
     * @inheritDoc
     */
    public function uploadFile(UploadedFile $file): string
    {
        // 名前をつけてS3へアップロード
        $originName = $file->getClientOriginalName();
        $fileName = Carbon::now()->format('Ymd_His') . '_' . $originName;
        $filePath = FileUploader::upload($file, 's3', self::S3_PREFIX, $fileName);
        return $filePath;
    }
}