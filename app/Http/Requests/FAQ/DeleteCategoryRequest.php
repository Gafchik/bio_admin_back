<?php

namespace App\Http\Requests\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category_id' => [
                'required',
                'int',
            ],
        ];
    }
}
