<?php

namespace App\Http\Requests\Users\Player;

use App\Http\Requests\ApiRequest;

class IndexRequest extends ApiRequest
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
            'sport_category_id' => 'nullable|integer',
            'name' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'dominant_arm' => 'nullable|integer|digits_between:0,2',
            'gender' => 'nullable|integer|digits_between:0,1',
            'backhand_style' => 'nullable|integer|digits_between:0,2',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'sport_category_id' => $this->get('sport_category_id'),
            'name' => $this->get('name'),
            'country' => $this->get('country'),
            'dominant_arm' => $this->get('dominant_arm'),
            'gender' => $this->get('gender'),
            'backhand_style' => $this->get('backhand_style'),
        ]);
    }
}