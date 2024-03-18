<?php

namespace App\Http\Requests\Backend\Student\Young;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProxyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => ['required'],
            'rut' => ['required', 'cl_rut'],
            'relationship' => ['required'],
            'phone' => ['required'],
            'commune_id' => ['required'],
            'address' => ['required']
        ];
    }
}
