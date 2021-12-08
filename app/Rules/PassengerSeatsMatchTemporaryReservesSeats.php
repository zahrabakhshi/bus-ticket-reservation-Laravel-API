<?php

namespace App\Rules;

use App\Models\TemporaryReserve;
use Illuminate\Contracts\Validation\Rule;

class PassengerSeatsMatchTemporaryReservesSeats implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $temporary_reserve = TemporaryReserve::find(request()->get('temporary_reserve_id'));
        $temporary_reserves_seats = json_decode($temporary_reserve->seats_json, true);

        $input_seats = collect($value)->pluck('seat_number')->toArray();

        if (!empty(array_diff($input_seats, $temporary_reserves_seats))) {
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
