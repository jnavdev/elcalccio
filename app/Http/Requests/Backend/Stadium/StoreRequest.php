<?php

namespace App\Http\Requests\Backend\Stadium;

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
            'name' => ['required', 'unique:stadiums,name']
        ];
    }
}
