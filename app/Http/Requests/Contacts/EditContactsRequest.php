<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class EditContactsRequest  extends FormRequest
{
    public function rules()
    {
        return [
            'id' => [
                'required',
                'int',
            ],
            'type' => [
                'required',
                'int',
            ],
            'social_type' => [
                'nullable',
                'int',
            ],
            'email' => [
                'nullable',
                'email',
            ],
            'phone' => [
                'nullable',
                'string',
            ],
            'url' => [
                'nullable',
                'url',
            ],
            'position' => [
                'required',
                'int',
            ],
            'status' => [
                'required',
                'boolean'
            ],
            'lang' => [
                'required',
                'array'
            ],
            'lang.ru' => [
                'array'
            ],
            'lang.uk' => [
                'array'
            ],
            'lang.en' => [
                'array'
            ],
            'lang.ge' => [
                'array'
            ],
        ];
    }
}
