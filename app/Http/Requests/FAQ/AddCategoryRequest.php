<?php

namespace App\Http\Requests\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'position' => [
                'required',
                'int',
            ],
            'status' => [
                'required',
                'boolean'
            ],
            'locale' => [
                'required',
                'array'
            ],
            'locale.ru' => [
                'required',
                'string'
            ],
            'locale.uk' => [
                'required',
                'string'
            ],
            'locale.en' => [
                'required',
                'string'
            ],
            'locale.ge' => [
                'required',
                'string'
            ],
        ];
    }
}
