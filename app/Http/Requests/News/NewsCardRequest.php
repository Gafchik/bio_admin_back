<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class NewsCardRequest extends FormRequest
{
    public function rules()
    {
        return [
            'page' => [
                'required',
                'int',
                'min:1'
            ],
        ];
    }
}

