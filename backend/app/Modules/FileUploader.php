<?php

namespace App\Modules;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploader
{
    /**
     * ファイルをアップロードする
     *
     * @param UploadedFile $file
     * @param string $diskName
     * @param string $dir
     * @param string $fileName
     * @return string $path
     */
    public static function upload(UploadedFile $file, string $diskName = 's3', string $dir = '', string $fileName = ''): string
    {
        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $filesystem = Storage::disk($diskName);
        $filePath = $filesystem->putFileAs($dir, $file, $fileName);
        $path = config("filesystems.disks.{$diskName}.url") . $filePath;
        Log::info('s3のファイルパス : ' . $path);
        return $path;
    }
}