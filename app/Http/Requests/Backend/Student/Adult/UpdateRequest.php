<?php

namespace App\Http\Requests\Backend\Student\Adult;

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
            'profile_picture' => ['nullable', 'mimes:jpg,jpeg,png'],
            'full_name' => ['required'],
            'rut' => ['required', 'cl_rut', Rule::unique('students', 'rut')->ignore($this->id)],
            'birth_date' => ['nullable', 'date_format:d-m-Y'],
            'commune_id' => ['required'],
            'authorization_file' => ['nullable', 'mimes:pdf']
        ];
    }
}
