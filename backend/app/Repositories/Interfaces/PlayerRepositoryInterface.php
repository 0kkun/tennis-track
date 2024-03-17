<?php

namespace App\Repositories\Interfaces;

use App\Eloquents\EloquentPlayer;
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
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void;

    /**
     * 選手を1件取得する
     *
     * @param int $id
     * @return EloquentPlayer
     */
    public function getById(int $id): EloquentPlayer;

    /**
     * 選手を1件登録する
     *
     * @param array $player
     * @return int
     */
    public function create(array $player): int;

    /**
     * 選手を1件アップデートする
     *
     * @param int $id
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

    /**
     * スポーツカテゴリーIDで選手を全て取得する
     *
     * @param int $sportCategoryId
     * @return Collection|null
     */
    public function fetchBySportCategoryId(int $sportCategoryId): ?Collection;

    /**
     * 選手情報を全て取得する
     *
     * @return Collection
     */
    public function fetch(): Collection;

    /**
     * 選手情報を更新するカラムを指定し一括アップデートを行う
     *
     * @param array $players
     * @return void
     */
    public function updateMultiple(array $players): void;
}
