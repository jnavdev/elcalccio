<?php

namespace App\Http\Requests\Backend\PaymentMethod;

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
            'account_number' => ['required'],
            'bank' => ['required']
        ];
    }
}
