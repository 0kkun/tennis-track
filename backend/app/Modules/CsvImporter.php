<?php

namespace App\Modules;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CsvImporter
{
    /**
     * CSV取り込み時の最大行数
     */
    private const MAX_ROW_COUNT = 100;

    /**
     * CSVファイルからデータを読み取り配列として返す
     * 1行目をヘッダー行とする
     *
     * @param string $filePath
     * @return array
     * @throws \Exception
     */
    public static function import(UploadedFile $filePath): array
    {
        Log::info('[CSV Import Start]');
        $file = new \SplFileObject($filePath);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );

        $header = null;
        $data = [];
        $rowCount = 0;

        foreach ($file as $row) {
            if ($header === null) {
                $header = $row;
            } else {
                $data[] = array_combine($header, $row);
            }
            $rowCount++;
        }

        if ($rowCount > self::MAX_ROW_COUNT) {
            throw new \Exception('最大行数を超えています.');
        }
        Log::info('[CSV Import End]');
        return $data;
    }
}