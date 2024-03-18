<?php

namespace App\Http\Requests\Backend\Album;

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
            'title' => ['required', 'max:255', Rule::unique('albums', 'title')->ignore($this->id)],
            'description' => ['required', 'max:255'],
            'date' => ['required', 'date_format:d-m-Y']
        ];
    }
}
