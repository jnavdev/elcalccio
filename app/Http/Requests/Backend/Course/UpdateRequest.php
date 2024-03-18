<?php

namespace App\Http\Requests\Backend\Course;

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
            'school_id' => ['required'],
            'name' => ['required', Rule::unique('courses', 'name')->ignore($this->id)],
            'description' => ['required'],
            'price' => ['required'],
            'period' => ['required']
        ];
    }
}
