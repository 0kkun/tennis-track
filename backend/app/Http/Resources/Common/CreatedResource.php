<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Response;

class CreatedResource extends BaseResource
{
    /**
     * status HTTPステータス
     */
    public $status = Response::HTTP_CREATED;

    /**
     * json_encode options 空オブジェクト
     */
    public function jsonOptions()
    {
        return JSON_FORCE_OBJECT;
    }
}
