<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class DeleteContactsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => [
                'required',
                'int',
            ],
        ];
    }
}
