<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Response;

class DestroyResource extends BaseResource
{
    /**
     * status HTTPステータス
     */
    public $status = Response::HTTP_NO_CONTENT;

    /**
     * json_encode options 空オブジェクト
     */
    public function jsonOptions()
    {
        return JSON_FORCE_OBJECT;
    }
}
