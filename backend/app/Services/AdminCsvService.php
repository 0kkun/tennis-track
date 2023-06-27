<?php

namespace App\Services;

use App\Modules\CsvExporter;
use App\Modules\CsvImporter;
use App\Modules\FileUploader;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Repositories\Interfaces\SportCategoryRepositoryInterface;
use App\Services\Interfaces\AdminCsvServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class AdminCsvService implements AdminCsvServiceInterface
{
    /**
     * @param PlayerRepositoryInterface $playerRepository
     * @param SportCategoryRepositoryInterface $sportCategoryRepository
     */
    public function __construct(
        private PlayerRepositoryInterface $playerRepository,
        private SportCategoryRepositoryInterface $sportCategoryRepository,
    ) {
        $this->playerRepository = $playerRepository;
        $this->sportCategoryRepository = $sportCategoryRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function importCsv(UploadedFile $file): array
    {
        $importer = new CsvImporter($file);
        $data = $importer->import();
        Log::info(print_r($data, true));

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function playerExportCsv(): string
    {
        $players = $this->playerRepository->fetch();
        // CSV出力する列
        $header = ['name_en', 'country'];
        // CSVファイルを作成
        $fileName = 'players_'.now()->format('Ymd_His').'.csv';
        $file = CsvExporter::export($header, $players, $fileName);
        $path = FileUploader::upload(new UploadedFile($file->getPathname(), $fileName), 's3', '/exports', $fileName);

        return $path;
    }

    /**
     * {@inheritDoc}
     */
    public function playerImportCsv(UploadedFile $file): array
    {
        $importer = new CsvImporter($file);
        $rules = [
            'name_en' => [
                'required',
                'string',
                'max:255',
                'unique:players,name_en',
            ],
            'country' => 'required|string|max:100',
            'gender' => 'required|integer|digits_between:0,1',
            'link' => 'required|string|max:300',
        ];
        $data = $importer->import($rules);

        return $data;
    }
}
