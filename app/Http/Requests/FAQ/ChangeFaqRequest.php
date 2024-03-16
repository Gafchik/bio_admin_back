<?php

namespace App\Http\Requests\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class ChangeFaqRequest extends FormRequest
{
    public function rules()
    {
        return [
            'question_id' => [
                'required',
                'int',
            ],
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
            'locale_question' => [
                'required',
                'array'
            ],
            'locale_question.ru' => [
                'required',
                'string'
            ],
            'locale_question.uk' => [
                'required',
                'string'
            ],
            'locale_question.en' => [
                'required',
                'string'
            ],
            'locale_question.ge' => [
                'required',
                'string'
            ],
            'locale_answer' => [
                'required',
                'array'
            ],
            'locale_answer.ru' => [
                'required',
                'string'
            ],
            'locale_answer.uk' => [
                'required',
                'string'
            ],
            'locale_answer.en' => [
                'required',
                'string'
            ],
            'locale_answer.ge' => [
                'required',
                'string'
            ],

        ];
    }
}
