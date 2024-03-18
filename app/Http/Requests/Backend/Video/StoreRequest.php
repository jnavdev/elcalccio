<?php

namespace App\Http\Requests\Backend\Video;

use App\Rules\Youtube;
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
            'title' => ['required', 'max:255'],
            'date' => ['required', 'date_format:d-m-Y'],
            'url' => ['required', new Youtube],
            'order' => ['required', 'numeric'],
            'is_active' => ['required'],
            'for_school' => ['required']
        ];
    }
}
