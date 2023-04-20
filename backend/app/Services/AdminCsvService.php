<?php

namespace App\Services;

use App\Modules\CsvImporter;
use App\Services\Interfaces\AdminCsvServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class AdminCsvService implements AdminCsvServiceInterface
{
    /**
     * @inheritDoc
     */
    public function importCsv(UploadedFile $file): array
    {
        $csvData = CsvImporter::import($file);
        Log::info(print_r($csvData, true));
        return $csvData;
    }
}