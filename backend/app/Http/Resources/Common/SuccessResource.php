<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Response;

class SuccessResource extends BaseResource
{
    /**
     * status
     */
    public $status = Response::HTTP_OK;

    /**
     * message
     */
    public $message = 'success';
}