<?php

namespace App\Http\Requests\Admins\File;

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
            'file' => 'required|max:1024',
        ];
    }

    /**
     * Validation Message
     *
     * @return void
     */
    public function messages()
    {
        return [
            'file.required' => 'ファイルを選択してください。',
        ];
    }
}
