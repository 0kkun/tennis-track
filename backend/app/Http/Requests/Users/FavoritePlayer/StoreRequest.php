<?php

namespace App\Http\Requests\Users\FavoritePlayer;

use App\Http\Requests\ApiRequest;

class StoreRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'player_id' => 'required|integer|exists:players,id',
        ];
    }

    /**
     * attributes
     */
    public function attributes()
    {
        return [
            'player_id' => 'プレイヤーID',
        ];
    }

    public function getParams(): array
    {
        return [
            'player_id' => $this->input('player_id')
        ];
    }
}
