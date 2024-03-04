<?php

namespace App\Http\Resources\FavoritePlayer;

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
        foreach ($this->resource as $favoritePlayer) {
            $results[] = [
                'id' => $favoritePlayer->id,
                'player_id' => $favoritePlayer->player_id,
                'name_en' => $favoritePlayer->player->name_en,
            ];
        }

        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $results,
        ];
    }
}
