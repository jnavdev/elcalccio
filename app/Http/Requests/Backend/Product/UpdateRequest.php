<?php

namespace App\Http\Requests\Backend\Product;

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
            'image' => ['nullable', 'mimes:jpg,jpeg,png'],
            'title' => ['required'],
            'description' => ['required'],
            'product_category_id' => ['required'],
            'cost_price' => ['required'],
            'sale_price' => ['required'],
            'stock' => ['required', 'numeric', 'gt:0']
        ];
    }
}
