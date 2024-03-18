<?php

namespace App\Http\Requests\Backend\MoneyClosure;

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
            'date' => ['required', 'unique:money_closures,date'],
            'cash_collected_total' => ['required'],
            'transfer_collected_total' => ['required'],
            'debt_collected_total' => ['required'],
            'credit_collected_total' => ['required'],
            'stadium_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'date.unique' => 'La fecha indicada ya esta cuadrada'
        ];
    }
}
