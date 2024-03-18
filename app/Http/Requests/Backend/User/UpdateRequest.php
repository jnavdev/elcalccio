<?php

namespace App\Http\Requests\Backend\User;

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
            'email' => ['required', Rule::unique('users', 'email')->ignore($this->id)],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'role_id' => ['required']
        ];
    }
}
