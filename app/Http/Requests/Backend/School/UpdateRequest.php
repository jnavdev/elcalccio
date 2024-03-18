<?php

namespace App\Http\Requests\Backend\School;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255', Rule::unique('schools', 'name')->ignore($this->id)]
        ];
    }
}
