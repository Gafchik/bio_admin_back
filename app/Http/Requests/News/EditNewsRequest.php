<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class EditNewsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => [
                'required',
                'int',
            ],
            'image' => [
                'required',
                'string',
            ],
            'date' => [
                'required',
                'string',
            ],
            'status' => [
                'required',
                'boolean'
            ],
            'ru' => [
                'required',
                'array'
            ],
            'uk' => [
                'required',
                'array'
            ],
            'en' => [
                'required',
                'array'
            ],
            'ge' => [
                'required',
                'array'
            ],
            'ru.name' => ['nullable', 'string',],
            'ru.short_content' => ['nullable', 'string',],
            'ru.content' => ['nullable', 'string',],
            'uk.name' => ['nullable', 'string',],
            'uk.short_content' => ['nullable', 'string',],
            'uk.content' => ['nullable', 'string',],
            'en.name' => ['nullable', 'string',],
            'en.short_content' => ['nullable', 'string',],
            'en.content' => ['nullable', 'string',],
            'ge.name' => ['nullable', 'string',],
            'ge.short_content' => ['nullable', 'string',],
            'ge.content' => ['nullable', 'string',],
        ];
    }
}
