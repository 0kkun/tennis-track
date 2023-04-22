<?php

namespace App\Http\Requests\Admins\Player;

use App\Http\Requests\ApiRequest;

class UpdateRequest extends ApiRequest
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
            'name_jp' => 'required|string|max:100',
            'name_en' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'birthday' => 'nullable|date_format:Y-m-d',
            'gender' => 'required|string|digits_between:0,1',
            'dominant_arm' => 'nullable|integer|digits_between:0,2',
            'gender' => 'nullable|integer|digits_between:0,1',
            'sport_category_id' => 'nullable|integer|exists:sport_categories',
        ];
    }

    /**
     * attributes
     */
    public function attributes()
    {
        return [
            'name_jp' => '名前(和)',
            'name_en' => '名前(英)',
            'country' => '出身国',
            'birthday' => '生年月日',
            'gender' => '性別',
            'backhand_style' => 'バックハンドスタイル',
            'dominant_arm' => '利き腕',
            'sport_category_id' => 'スポーツカテゴリ',
        ];
    }

    public function getParams(): array
    {
        return [
            'name_jp' => $this->input('name_jp'),
            'name_en' => $this->input('name_en'),
            'country' => $this->input('country'),
            'birthday' => $this->input('birthday'),
            'gender' => $this->input('gender'),
            'backhand_style' => $this->input('backhand_style'),
            'dominant_arm' => $this->input('dominant_arm'),
            'sport_category_id' => $this->input('sport_category_id')
        ];
    }

    public function prepareForValidation()
    {
        // パスパラメータのidをFormRequestのattribute(バリデーションチェック対象)として扱う
        $this->merge(['id' => $this->route('player')]);
    }
}
