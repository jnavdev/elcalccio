<?php

namespace App\Http\Requests\Frontend\MyAccount;

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
            'name' => ['required'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(auth()->user()->id)],
            'rut' => ['required', 'cl_rut', Rule::unique('users', 'rut')->ignore(auth()->user()->id)],
            'phone' => ['required'],
            'password' => ['nullable', 'min:6']
        ];
    }
}
