<?php

namespace App\Http\Controllers\Apis\V1\Users\Player;

use App\Http\Controllers\Controller;
use App\Http\Resources\Player\IndexResource;
use App\Modules\ApplicationLogger;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use Illuminate\Http\Request;

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
    public function index(Request $request): IndexResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('選手一覧取得開始');
            $logger->write('[Request Params]' . print_r($request->all(), true));
            $searchParams = $this->getSearchParams($request);
            $players = $this->playerRepository->fetchByParams($searchParams);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new IndexResource($players);
    }

    private function getSearchParams($request): array
    {
        return $request->only([
            'sport_category_id',
            'name',
            'country',
            'dominant_arm',
            'backhand_style',
        ]);
    }
}