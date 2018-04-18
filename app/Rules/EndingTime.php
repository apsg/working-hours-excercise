<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EndingTime implements Rule
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
        $startingHour = explode(":", request()->starting_hour);
        $endingHour = explode(":", $value);

        if($endingHour[0] > $startingHour[0])
            return true;

        if($endingHour[0] == $startingHour[0] 
            && $endingHour[1] > $startingHour[1] )
            return true;

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ending hour must be later than starting hour.';
    }
}
