<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Response;

class InvalidResource extends BaseResource
{
    /**
     * status
     */
    public $status = Response::HTTP_UNPROCESSABLE_ENTITY;
}
