<?php

namespace App\Http\Requests\Backend\Customer;

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
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'rut' => ['required', 'cl_rut', 'unique:users,rut'],
            'phone' => ['required', 'max:255'],
            'partner' => ['required'],
            'password' => ['required', 'min:6']
        ];
    }
}
