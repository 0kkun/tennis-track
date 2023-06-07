<?php

namespace App\Modules;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CsvExporter
{
    /**
     * CSVファイル出力
     * データベースから取得したデータをカラム毎に列に格納する
     * @param array $header
     * @param Collection|array $records
     * @param string $fileName
     * @return \SplFileObject
     */
    public static function export(array $header, Collection|array $records, string $fileName): \SplFileObject
    {
        Log::info('[CSV Export Start]');
        // CSVファイルを作成
        $file = new \SplFileObject($fileName, 'w');

        // 文字コードをUTF-8に設定
        $file->fwrite(chr(0xEF) . chr(0xBB) . chr(0xBF));

        $file->fputcsv($header);

        // レコードをCSVファイルに書き込む
        $rowCount = 0;
        foreach ($records as $record) {
            $data = [];
            foreach ($header as $column) {
                $data[] = $record[$column];
            }
            $file->fputcsv($data);
            $rowCount++;
        }

        // ファイルを閉じる
        unset($file);

        Log::info('[CSV Export End] rowCount:' . $rowCount);
        return new \SplFileObject($fileName);
    }
}
