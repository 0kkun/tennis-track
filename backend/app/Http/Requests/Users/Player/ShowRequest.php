<?php

namespace App\Http\Requests\Users\Player;

use App\Http\Requests\ApiRequest;

class ShowRequest extends ApiRequest
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
            'id' => 'required|integer|exists:players',
        ];
    }

    public function prepareForValidation()
    {
        // パスパラメータのidをFormRequestのattribute(バリデーションチェック対象)として扱う
        $this->merge(['id' => $this->route('players')]);
    }
}