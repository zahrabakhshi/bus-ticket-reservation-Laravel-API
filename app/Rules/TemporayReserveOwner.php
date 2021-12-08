<?php

namespace App\Rules;

use App\Models\TemporaryReserve;
use Illuminate\Contracts\Validation\Rule;

class TemporayReserveOwner implements Rule
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
        $temporary_reserve_id = $value;
         $user_id = auth('api')->id();

        if(TemporaryReserve::findOrFail($temporary_reserve_id)->user->id !== $user_id ){
            return false;
        }
        return true;
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
