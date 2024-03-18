<?php

namespace App\Http\Requests\Backend\Customer;

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
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->id)],
            'rut' => ['required', 'cl_rut', Rule::unique('users', 'rut')->ignore($this->id)],
            'phone' => ['required', 'max:255'],
            'partner' => ['required'],
            'password' => ['nullable', 'min:6']
        ];
    }
}
