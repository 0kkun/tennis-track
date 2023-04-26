<?php

namespace App\Http\Resources\Player;

use App\Http\Resources\Common\BaseResource;
use Symfony\Component\HttpFoundation\Response;

class ExportResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        if (empty($this->resource)) {
            return [
                'status' => Response::HTTP_NO_CONTENT,
                'message' => $this->message,
                'data' => '',
            ];
        }
        $results = [
            'path' => $this->resource,
        ];
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $results,
        ];
    }
}
