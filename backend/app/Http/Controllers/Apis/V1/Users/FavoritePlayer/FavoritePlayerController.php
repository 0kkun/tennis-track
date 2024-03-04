<?php

namespace App\Http\Controllers\Apis\V1\Users\FavoritePlayer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\FavoritePlayer\DestroyRequest;
use App\Http\Requests\Users\FavoritePlayer\StoreRequest;
use App\Http\Resources\Common\CreatedResource;
use App\Http\Resources\Common\DestroyResource;
use App\Http\Resources\FavoritePlayer\IndexResource;
use App\Modules\ApplicationLogger;
use App\Repositories\Interfaces\FavoritePlayerRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class FavoritePlayerController extends Controller
{
    /**
     * @param FavoritePlayerRepositoryInterface $favoritePlayerRepository
     */
    public function __construct(
        private FavoritePlayerRepositoryInterface $favoritePlayerRepository,
    ) {
        $this->favoritePlayerRepository = $favoritePlayerRepository;
    }

    /**
     * お気に入り選手一覧取得
     *
     * @throws Exception
     * @return IndexResource
     */
    public function index(): IndexResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('ログインユーザーのお気に入り選手一覧取得開始');
            $userId = Auth::user()->id;
            $favoritePlayers = $this->favoritePlayerRepository->fetchWithPlayerByUserId($userId);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new IndexResource($favoritePlayers);
    }

    /**
     * お気に入り選手を一件生成する
     *
     * @param StoreRequest $request
     * @throws Exception
     * @return CreatedResource
     */
    public function store(StoreRequest $request): CreatedResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('お気に入り選手登録開始');
            $userId = Auth::user()->id;
            $logger->write('[Request Params]'.print_r($request->all(), true));
            $params = $request->getParams();
            $this->favoritePlayerRepository->create($userId, $params['player_id']);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new CreatedResource();
    }

    /**
     * お気に入り選手を1件削除
     *
     * @param DestroyRequest $request
     * @throws Exception
     * @return DestroyResource
     */
    public function destroy(DestroyRequest $request): DestroyResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $logger->write('お気に入り選手1件削除開始');
            $logger->write('[Request Params]'.print_r($request->all(), true));
            $id = $request->input('id');
            $this->favoritePlayerRepository->destroy($id);
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();

        return new DestroyResource();
    }
}
