<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Time implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^([0]{1}[0-9]{1}|[1][0-9]|2[0-3]):(\d{2})$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Hour format invalid. Valid format: HH:mm ';
    }
}
