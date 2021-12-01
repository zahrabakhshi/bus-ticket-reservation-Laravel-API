<?php

namespace App\Rules;

use App\Http\Controllers\API\FreeSeats;
use Illuminate\Contracts\Validation\Rule;

class SeatsAvailable implements Rule
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
        $trip_id = request()->get('trip_id');
        $free_seats_array = FreeSeats::findFreeSeats($trip_id);

        if(!in_array($value,$free_seats_array)){
            return false;
        }else{
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
