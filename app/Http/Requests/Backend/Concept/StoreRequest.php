<?php

namespace App\Http\Requests\Backend\Concept;

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
            'name' => ['required'],
            'type' => ['required']
        ];
    }
}
