<?php

namespace App\Http\Requests\Users\TennisAtpRanking;

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
            'name' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => $this->get('name'),
            'country' => $this->get('country'),
        ]);
    }

    public function getParams(): array
    {
        return [
            'name' => $this->input('name'),
            'country' => $this->input('country'),
        ];
    }
}
