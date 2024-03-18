<?php

namespace App\Http\Requests\Backend\Movement;

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
            'date' => ['required'],
            'amount' => ['required'],
            'concept_id_income' => ['required_if:concept_type,Ingreso'],
            'concept_id_expense' => ['required_if:concept_type,Gasto'],
            'payment_method_id' => ['required_if:payment_type,bank']
        ];
    }

    public function messages()
    {
        return [
            'payment_method_id.required_if' => 'El campo cuenta bancaria es obligatorio.',
            'concept_id_income.required_if' => 'El campo concepto es obligatorio.',
            'concept_id_expense.required_if' => 'El campo concepto es obligatorio.'
        ];
    }
}
