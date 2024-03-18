<?php

namespace App\Http\Requests\Backend\ProductCategory;

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
            'name' => ['required', 'unique:product_categories,name']
        ];
    }
}
