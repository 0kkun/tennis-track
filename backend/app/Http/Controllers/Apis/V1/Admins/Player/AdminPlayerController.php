<?php

namespace App\Http\Controllers\Apis\V1\Admins\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\Player\DestroyRequest;
use App\Http\Requests\Admins\Player\StoreRequest;
use App\Http\Requests\Admins\Player\ShowRequest;
use App\Http\Requests\Admins\Player\IndexRequest;
use App\Http\Requests\Admins\Player\UpdateRequest;
use App\Http\Resources\Common\CreatedResource;
use App\Http\Resources\Common\DestroyResource;
use App\Http\Resources\Common\UpdatedResource;
use App\Http\Resources\Player\IndexResource;
use App\Http\Resources\Player\ShowResource;
use App\Modules\ApplicationLogger;
use App\Repositories\Interfaces\PlayerRepositoryInterface;

class AdminPlayerController extends Controller
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
            $searchParams = $this->getSearchParams($request);
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
            $playerId = $request->id;
            $this->playerRepository->getById($playerId);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new ShowResource();
    }

    /**
     * 選手を1件登録
     *
     * @param StoreRequest $request
     * @return CreatedResource
     */
    public function store(StoreRequest $request): CreatedResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('選手一覧1件登録開始');
            $logger->write('[Request Params]' . print_r($request->all(), true));
            $player = $request->getParams();
            $this->playerRepository->create($player);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new CreatedResource();
    }

    /**
     * 選手を1件更新
     *
     * @param UpdateRequest $request
     * @return UpdatedResource
     */
    public function update(UpdateRequest $request): UpdatedResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('選手一覧1件更新開始');
            $logger->write('[Request Params]' . print_r($request->all(), true));
            $player = $request->getParams();
            $this->playerRepository->update($player['id'], $player);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new UpdatedResource();
    }

    /**
     * 選手を1件削除
     *
     * @param DestroyRequest $request
     * @return DestroyResource
     */
    public function destroy(DestroyRequest $request): DestroyResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('選手一覧1件削除開始');
            $logger->write('[Request Params]' . print_r($request->all(), true));
            $playerId = $request->input('id');
            $this->playerRepository->destroy($playerId);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new DestroyResource();
    }

    /**
     * 検索パスパラメータを取得
     *
     * @param IndexRequest $request
     * @return array
     */
    private function getSearchParams(IndexRequest $request): array
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