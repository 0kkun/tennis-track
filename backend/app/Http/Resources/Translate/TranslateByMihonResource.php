<?php

namespace App\Http\Resources\Translate;

use App\Http\Resources\Common\BaseResource;
use Symfony\Component\HttpFoundation\Response;

class TranslateByMihonResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
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

        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->resource['resultset']['result']['text'],
        ];
    }
}
