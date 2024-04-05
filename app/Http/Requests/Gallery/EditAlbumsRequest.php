<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class EditAlbumsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id_album' => [
                'required',
                'int',
            ],
            'category_image' => [
                'required',
                'string',
            ],
            'status' => [
                'required',
                'boolean'
            ],
            'is_image' => [
                'required',
                'boolean'
            ],
            'name_ru' => [
                'required',
                'string',
            ],
            'name_uk' => [
                'required',
                'string',
            ],
            'name_en' => [
                'required',
                'string',
            ],
            'name_ge' => [
                'required',
                'string',
            ],
            'items' => [
                'array'
            ]
        ];
    }
}
