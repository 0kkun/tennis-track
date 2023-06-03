<?php

namespace App\Http\Resources\Player;

use App\Http\Resources\Common\BaseResource;
use Symfony\Component\HttpFoundation\Response;

class IndexResource extends BaseResource
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

        $results = [];
        foreach ($this->resource as $player) {
            $results [] = [
                'id' => $player->id,
                'name_jp' => $player->name_jp,
                'name_en' => $player->name_en,
                'birthday' => $player->birthday,
                'age' => $player->getAge(),
                'country' => $player->country,
                'gender' => $player->convertGenderString(),
                'backhand_style' => $player->convertBackhandStyleString(),
                'dominant_arm' => $player->convertDominantArmString(),
                'sport_category' => $player->sportCategory->name,
            ];
        }
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $results,
        ];
    }
}
