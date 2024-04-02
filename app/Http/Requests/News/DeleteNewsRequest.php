<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class DeleteNewsRequest  extends FormRequest
{
    public function rules()
    {
        return [
            'id' => [
                'required',
                'int',
            ]
        ];
    }
}

