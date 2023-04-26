<?php

namespace App\Services;

use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Repositories\Interfaces\SportCategoryRepositoryInterface;
use App\Services\Interfaces\AdminCsvServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Modules\CsvImporter;

class AdminCsvService implements AdminCsvServiceInterface
{
    /**
     * @param PlayerRepositoryInterface $playerRepository
     * @param SportCategoryRepositoryInterface $sportCategoryRepository
     */
    public function __construct(
        private PlayerRepositoryInterface $playerRepository,
        private SportCategoryRepositoryInterface $sportCategoryRepository,
    )
    {
        $this->playerRepository = $playerRepository;
        $this->sportCategoryRepository = $sportCategoryRepository;
    }

    /**
     * @inheritDoc
     */
    public function importCsv(UploadedFile $file): array
    {
        $importer = new CsvImporter($file);
        $data = $importer->import();
        Log::info(print_r($data, true));
        return $data;
    }

    public function playerExportCsv()
    {
        $sportCategoryId = $this->sportCategoryRepository->getIdByName('テニス');
        $params = [
            'sport_category_id' => $sportCategoryId,
        ];
        $players = $this->playerRepository->fetchByParams($params);

    }

    /**
     * @inheritDoc
     */
    public function playerImportCsv(UploadedFile $file): array
    {
        $importer = new CsvImporter($file);
        $rules = [
            'name_en' => [
                'required',
                'string',
                'max:255',
                'unique:players,name_en'
            ],
            'country' => 'required|string|max:100',
            'gender' => 'required|integer|digits_between:0,1',
            'link' => 'required|string|max:300',
        ];
        $data = $importer->import($rules);
        return $data;
    }
}