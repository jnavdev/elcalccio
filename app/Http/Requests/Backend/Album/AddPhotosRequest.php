<?php

namespace App\Http\Requests\Backend\Album;

use Illuminate\Foundation\Http\FormRequest;

class AddPhotosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'photos' => 'required'
        ];
    }
}
