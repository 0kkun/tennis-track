<?php

namespace App\Http\Resources\TennisAtpRanking;

use App\Http\Resources\Common\BaseResource;
use Symfony\Component\HttpFoundation\Response;

class ShowResource extends BaseResource
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
            'id' => $this->resource->id,
            'current_rank' => $this->resource->current_rank,
            'current_point' => $this->resource->current_point,
            'rank_change' => $this->resource->rank_change,
            'player_id' => $this->resource->player_id,
            'name_en' => $this->resource->player->name_en,
            'country' => $this->resource->player->country,
            'link' => $this->resource->player->link,
            'birthday' => $this->resource->player->birthday,
            'age' => $this->resource->player->getAge(),
            'gender' => $this->resource->player->convertGenderString(),
            'backhand_style' => $this->resource->player->convertBackhandStyleString(),
            'dominant_arm' => $this->resource->player->convertDominantArmString(),
        ];
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $results,
        ];
    }
}
