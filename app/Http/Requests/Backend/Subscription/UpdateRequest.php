<?php

namespace App\Http\Requests\Backend\Subscription;

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
            'student_id' => ['required'],
            'course_id' => ['required'],
            'start_date' => ['required', 'date_format:d-m-Y'],
            'end_date' => ['required', 'date_format:d-m-Y', 'after_or_equal:start_date'],
            'total' => ['required'],
            'payment_media' => ['required']
        ];
    }
}
