<?php

namespace App\Http\Requests\Backend\MoneyClosure;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cash_collected_total' => ['required'],
            'transfer_collected_total' => ['required'],
            'debt_collected_total' => ['required'],
            'credit_collected_total' => ['required']
        ];
    }
}
