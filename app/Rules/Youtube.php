<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Youtube implements Rule
{
    public function passes($attribute, $value)
    {
        return (bool) preg_match('/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/',$value);
    }

    public function message()
    {
        return 'El campo :attribute debe ser un enlace de YouTube.';
    }
}
