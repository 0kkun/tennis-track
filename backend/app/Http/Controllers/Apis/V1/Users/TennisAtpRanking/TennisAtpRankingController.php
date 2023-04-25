<?php

namespace App\Http\Controllers\Apis\V1\Users\TennisAtpRanking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\TennisAtpRanking\ShowRequest;
use App\Http\Requests\Users\TennisAtpRanking\IndexRequest;
use App\Http\Resources\TennisAtpRanking\IndexResource;
use App\Http\Resources\TennisAtpRanking\ShowResource;
use App\Modules\ApplicationLogger;
use App\Repositories\Interfaces\TennisAtpRankingRepositoryInterface;

class TennisAtpRankingController extends Controller
{
    /**
     * @param TennisAtpRankingRepositoryInterface $tennisAtpRankingRepository
     */
    public function __construct(
        private TennisAtpRankingRepositoryInterface $tennisAtpRankingRepository,
    )
    {
        $this->tennisAtpRankingRepository = $tennisAtpRankingRepository;
    }

    /**
     * ランキング一覧取得
     *
     * @return IndexResource
     * @throws Exception
     */
    public function index(IndexRequest $request): IndexResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('ATPランキング一覧取得開始');
            $searchParams = $request->getParams();
            $logger->write('[Request Params]' . print_r($searchParams, true));
            $players = $this->tennisAtpRankingRepository->fetchByParams($searchParams);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new IndexResource($players);
    }

    /**
     * ランキング詳細取得
     *
     * @param ShowRequest $request
     * @return ShowResource
     */
    public function show(ShowRequest $request): ShowResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('ATPランキング詳細取得開始');
            $logger->write('[Request Params]' . print_r($request->all(), true));
            $rankings = $this->tennisAtpRankingRepository->getById($request->id);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new ShowResource($rankings);
    }
}