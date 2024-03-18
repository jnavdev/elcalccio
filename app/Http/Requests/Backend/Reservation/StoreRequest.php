<?php

namespace App\Http\Requests\Backend\Reservation;

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
            'res' => ['required'],
            'payment_media' => ['required'],
            'total' => ['required'],
            'rut' => ['required'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'res.required' => 'Debe seleccionar al menos una hora',
            'payment_media.required' => 'El campo método de pago es obligatorio'
        ];
    }
}
