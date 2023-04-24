<?php

namespace App\Repositories\Interfaces;

use App\Models\Player;
use Illuminate\Support\Collection;

interface PlayerRepositoryInterface
{
    /**
     * 検索パラメータを用いて選手を取得する
     *
     * @param array $searchParams
     * @return Collection|null
     */
    public function fetchByParams(array $searchParams): ?Collection;

    /**
     * 選手を1件削除する
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id): void;

    /**
     * 選手を1件取得する
     *
     * @param integer $id
     * @return Player
     */
    public function getById(int $id): Player;

    /**
     * 選手を1件登録する
     *
     * @param array $player
     * @return void
     */
    public function create(array $player): void;

    /**
     * 選手を1件アップデートする
     *
     * @param integer $id
     * @param array $player
     * @return void
     */
    public function update(int $id, array $player): void;

    /**
     * upsertを行う. 
     * name_enが同じのものはupdate、それ以外はinsert
     *
     * @param array $params upsertするパラメータ
     * @return void
     */
    public function upsertByNameEn(array $params): void;
}