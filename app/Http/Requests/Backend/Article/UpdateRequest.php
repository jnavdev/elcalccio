<?php

namespace App\Http\Requests\Backend\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:10240'],
            'title' => ['required', 'max:255', Rule::unique('articles', 'title')->ignore($this->id)],
            'content' => ['required'],
            'date' => ['required']
        ];
    }
}
