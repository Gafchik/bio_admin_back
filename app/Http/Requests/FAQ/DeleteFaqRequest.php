<?php

namespace App\Http\Requests\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFaqRequest extends FormRequest
{
    public function rules()
    {
        return [
            'question_id' => [
                'required',
                'int',
            ]
        ];
    }
}
