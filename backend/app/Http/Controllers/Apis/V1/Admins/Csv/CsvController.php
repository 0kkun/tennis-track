<?php

namespace App\Http\Controllers\Apis\V1\Admins\Csv;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\Csv\StoreRequest;
use App\Http\Resources\Common\CreatedResource;
use App\Http\Resources\Common\SuccessResource;
use App\Modules\ApplicationLogger;
use App\Services\Interfaces\AdminCsvServiceInterface;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    /**
     * @param AdminCsvServiceInterface $adminCsvService
     */
    public function __construct(
        private AdminCsvServiceInterface $adminCsvService,
    )
    {
        $this->adminCsvService = $adminCsvService;
    }

    /**
     * CSVエクスポート
     *
     * @param Request $request
     * @return SuccessResource
     */
    public function index(Request $request): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        $logger->success();
        return new SuccessResource(['success']);
    }

    /**
     * CSVインポート
     *
     * @param StoreRequest $request
     * @return CreatedResource
     */
    public function store(StoreRequest $request): CreatedResource
    {
        $logger = new ApplicationLogger(__METHOD__);

        try {
            $this->adminCsvService->importCsv($request->file('file'));
            $logger->success();
            return new CreatedResource();
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
    }
}