<?php

namespace App\Http\Requests\Backend\School;

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
            'name' => ['required', 'max:255', 'unique:schools,name']
        ];
    }
}
