<?php

namespace App\Http\Requests\Backend\Article;

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
            'image' => ['required', 'mimes:jpg,jpeg,png', 'max:10240'],
            'title' => ['required', 'max:255', 'unique:articles,title'],
            'content' => ['required'],
            'date' => ['required']
        ];
    }
}
