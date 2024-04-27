<?php

namespace Tests\Unit\Modules;

use App\Modules\CsvExporter;
use Tests\TestCase;

class CsvExporterTest extends TestCase
{
    /**
     * @return void
     */
    public function testCsvExport(): void
    {
        $header = ['id', 'name', 'email'];

        $records = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com'],
        ];

        $fileName = 'exported_data.csv';

        // CSVファイルをエクスポート
        $exportedFile = CsvExporter::export($header, $records, $fileName);

        // ファイルが存在するかどうかを確認
        $this->assertTrue(file_exists($exportedFile->getPathname()));

        // ファイルを削除
        CsvExporter::deleteFile($exportedFile->getPathname());

        // ファイルが削除されたことを確認
        $this->assertFalse(file_exists($exportedFile->getPathname()));
    }
}
