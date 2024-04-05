<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class AlbumIdRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => [
                'required',
                'int',
            ]
        ];
    }
}
