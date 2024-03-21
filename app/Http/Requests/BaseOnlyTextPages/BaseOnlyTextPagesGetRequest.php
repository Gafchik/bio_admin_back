<?php

namespace App\Http\Requests\BaseOnlyTextPages;

use Illuminate\Foundation\Http\FormRequest;

class BaseOnlyTextPagesGetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => [
                'required',
                'int',
            ],
        ];
    }
}
