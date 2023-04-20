<?php

namespace App\Http\Controllers\Apis\V1\Admins\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\File\StoreRequest;
use App\Http\Resources\Common\CreatedResource;
use App\Http\Resources\Common\SuccessResource;
use App\Modules\ApplicationLogger;
use App\Services\Interfaces\AdminFileServiceInterface;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * @param AdminFileServiceInterface $adminFileService
     */
    public function __construct(
        private AdminFileServiceInterface $adminFileService,
    )
    {
        $this->adminFileService = $adminFileService;
    }

    /**
     * ファイルダウンロード
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
     * ファイルアップロード
     *
     * @param StoreRequest $request
     * @return CreatedResource
     */
    public function store(StoreRequest $request): CreatedResource
    {
        $logger = new ApplicationLogger(__METHOD__);

        try {
            $this->adminFileService->uploadFile($request->file('file'));
            $logger->success();
            return new CreatedResource();
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
    }
}