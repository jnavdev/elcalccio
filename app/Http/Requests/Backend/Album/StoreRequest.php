<?php

namespace App\Http\Requests\Backend\Album;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:255', 'unique:albums,title'],
            'description' => ['required', 'max:255'],
            'date' => ['required', 'date_format:d-m-Y'],
            'photos' => ['required']
        ];
    }
}
