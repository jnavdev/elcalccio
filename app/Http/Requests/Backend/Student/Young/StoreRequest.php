<?php

namespace App\Http\Requests\Backend\Student\Young;

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
            'profile_picture' => ['nullable', 'mimes:jpg,jpeg,png'],
            'full_name' => ['required'],
            'rut' => ['required', 'cl_rut', 'unique:students,rut'],
            'birth_date' => ['nullable', 'date_format:d-m-Y'],
            'commune_id' => ['required'],
            'proxy_full_name' => ['required'],
            'proxy_rut' => ['required'],
            'proxy_relationship' => ['required'],
            'proxy_phone' => ['required'],
            'proxy_commune_id' => ['required'],
            'authorization_file' => ['nullable', 'mimes:pdf']
        ];
    }
}
