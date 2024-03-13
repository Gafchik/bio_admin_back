<?php

namespace App\Http\Requests\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class ChangeCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category_id' => [
                'required',
                'int',
            ],
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
