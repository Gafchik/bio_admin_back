<?php

namespace App\Http\Requests\BaseOnlyTextPages;

use Illuminate\Foundation\Http\FormRequest;

class BaseOnlyTextPagesEditRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => [
                'required',
                'int',
            ],
            'lang' => [
                'required',
                'array'
            ],
            'lang.ru' => [
                'nullable',
                'string',
            ],
            'lang.uk' => [
                'nullable',
                'string',
            ],
            'lang.en' => [
                'nullable',
                'string',
            ],
            'lang.ge' => [
                'nullable',
                'string',
            ],
        ];
    }
}
