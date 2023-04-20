<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Response;

class ErrorResource extends BaseResource
{
    /**
     * status
     */
    public $status = Response::HTTP_INTERNAL_SERVER_ERROR;
}
