<?php

namespace App\Http\Requests\Admins\Translate;

use App\Http\Requests\ApiRequest;

class TranslateByMihonRequest extends ApiRequest
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
            'text' => 'nullable|string|max:1000',
            'split' => 'nullable|integer|digits_between:0,1',
            'history' => 'nullable|integer|digits_between:0,3',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'text' => $this->get('text'),
            'split' => $this->get('split'),
            'history' => $this->get('history'),
        ]);
    }

    public function getParams()
    {
        return [
            'text' => $this->input('text'), // 翻訳したいテキスト
            'split' => $this->input('split'), // 文章区切り [0:OFF / 1:ON]
            'history' => $this->input('history'), // 文脈利用翻訳 [0:利用しない / 1:前1文 / 2:前2文 / 3:前3文]
        ];
    }
}