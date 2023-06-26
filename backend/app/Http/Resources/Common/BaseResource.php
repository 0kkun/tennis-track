<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class BaseResource extends JsonResource
{
    /**
     * status
     */
    public $status = Response::HTTP_OK;

    /**
     * message
     */
    public $message;

    /**
     * @param mixed $resource
     * @param int $status HTTPステータス
     * @return void
     */
    public function __construct($resource = [], int $status = 0)
    {
        $this->status = $status ?: $this->status;
        $this->message = config('api_response.messages.'.$this->status);
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => parent::toArray($request),
        ];
    }

    /**
     * withResponse
     *
     * @param Request $request
     * @param Response $response
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->status);
    }
}
