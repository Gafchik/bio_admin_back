<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class Google2facRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'code' => [
                'required',
                'string',
                'max:6',
                'max:6',
            ],
        ];
    }
}
