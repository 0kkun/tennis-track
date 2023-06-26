<?php

namespace App\Http\Resources\TennisAtpRanking;

use App\Http\Resources\Common\BaseResource;
use Symfony\Component\HttpFoundation\Response;

class IndexResource extends BaseResource
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

        $results = [];
        foreach ($this->resource as $tennisAtpRanking) {
            $results[] = [
                'id' => $tennisAtpRanking->id,
                'current_rank' => $tennisAtpRanking->current_rank,
                'current_point' => $tennisAtpRanking->current_point,
                'rank_change' => $tennisAtpRanking->rank_change,
                'player_id' => $tennisAtpRanking->player_id,
                'name_en' => $tennisAtpRanking->player->name_en,
                'country' => $tennisAtpRanking->player->country,
                'link' => $tennisAtpRanking->player->link,
                'age' => $tennisAtpRanking->player->getAge(),
            ];
        }

        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $results,
        ];
    }
}
