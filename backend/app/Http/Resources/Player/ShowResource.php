<?php

namespace App\Http\Resources\Player;

use App\Http\Resources\Common\BaseResource;
use Symfony\Component\HttpFoundation\Response;

class ShowResource extends BaseResource
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
        $results = [
            'id' => $this->resource->id,
            'name_jp' => $this->resource->name_jp,
            'name_en' => $this->resource->name_en,
            'birthday' => $this->resource->birthday,
            'age' => $this->resource->getAge(),
            'country' => $this->resource->country,
            'turn_to_pro_year' => $this->resource->turn_to_pro_year,
            'gender' => $this->resource->convertGenderString(),
            'backhand_style' => $this->resource->convertBackhandStyleString(),
            'dominant_arm' => $this->resource->convertDominantArmString(),
            'sport_category' => $this->resource->sportCategory->name,
        ];

        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $results,
        ];
    }
}
