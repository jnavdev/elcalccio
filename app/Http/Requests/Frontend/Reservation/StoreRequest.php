<?php

namespace App\Http\Requests\Frontend\Reservation;

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
            'res' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'res.required' => 'Debe seleccionar al menos una hora'
        ];
    }
}
