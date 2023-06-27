<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ApiRequest extends FormRequest
{
    /**
     * {@inheritDoc}
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
