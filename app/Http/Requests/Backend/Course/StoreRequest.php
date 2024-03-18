<?php

namespace App\Http\Requests\Backend\Course;

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
            'school_id' => ['required'],
            'name' => ['required', 'unique:courses,name'],
            'description' => ['required'],
            'price' => ['required'],
            'period' => ['required']
        ];
    }
}
