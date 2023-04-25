<?php

namespace App\Http\Controllers\Apis\V1\Users\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Player\ShowRequest;
use App\Http\Requests\Users\Player\IndexRequest;
use App\Http\Resources\Player\IndexResource;
use App\Http\Resources\Player\ShowResource;
use App\Modules\ApplicationLogger;
use App\Repositories\Interfaces\PlayerRepositoryInterface;

class PlayerController extends Controller
{
    /**
     * @param PlayerRepositoryInterface $playerRepository
     */
    public function __construct(
        private PlayerRepositoryInterface $playerRepository,
    )
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * 選手一覧取得
     *
     * @return IndexResource
     * @throws Exception
     */
    public function index(IndexRequest $request): IndexResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('選手一覧取得開始');
            $logger->write('[Request Params]' . print_r($request->all(), true));
            $searchParams = $request->getParams();
            $players = $this->playerRepository->fetchByParams($searchParams);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new IndexResource($players);
    }

    /**
     * 選手詳細取得
     *
     * @param ShowRequest $request
     * @return ShowResource
     */
    public function show(ShowRequest $request): ShowResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('選手一覧詳細取得開始');
            $logger->write('[Request Params]' . print_r($request->all(), true));
            $player = $this->playerRepository->getById($request->id);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new ShowResource($player);
    }
}