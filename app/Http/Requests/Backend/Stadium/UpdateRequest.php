<?php

namespace App\Http\Requests\Backend\Stadium;

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
            'name' => ['required', Rule::unique('stadiums', 'name')->ignore($this->id)]
        ];
    }
}
