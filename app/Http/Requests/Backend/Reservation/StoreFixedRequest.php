<?php

namespace App\Http\Requests\Backend\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class StoreFixedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => ['required'],
            'end_date' => ['required'],
            'days' => ['required'],
            'hours' => ['required'],
            'payment_media' => ['required'],
            'hour_price' => ['required'],
            'rut' => ['required'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'start_date.required' => 'El campo desde es obligatorio',
            'end_date.required' => 'El campo hasta es obligatorio',
            'days.required' => 'El campo dias es obligatorio',
            'hours.required' => 'El campo horas es obligatorio',
            'payment_media.required' => 'El campo método de pago es obligatorio'
        ];
    }
}
