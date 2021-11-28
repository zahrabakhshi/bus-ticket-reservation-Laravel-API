<?php

namespace App\Rules;

use App\Models\Passenger;
use App\Models\Trip;
use Illuminate\Contracts\Validation\Rule;

class uniquePassengerEveryTrip implements Rule
{

    protected $common_national_codes;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $trip_id = $value;

        //If no ticket was stored for this trip, then any passenger can be store
        if(Trip::findOrFail($trip_id)->tickets()->doesntExist()){
            return true;
        }

        //Get current travel passengers id
        $trip_passengers = Trip::findOrFail($trip_id)->tickets->pluck('passenger_id')->toArray();

        //Get the national code of the passengers sent in the user request
        $request_national_codes = array_column(request()->get('passengers'), 'national_code');

        $request_passengers = [];

        //For each national code entered by the user
        foreach ($request_national_codes as $request_national_code) {

            //If with this national code there were no passengers in the database
            //This means that the passengers requested by the user have been validated
            //Otherwise, the passenger's face ID will put the user request in the $request_passengers array
            if (Passenger::where('national_code', $request_national_code)->doesntExist())
                return true;
            else
                $request_passengers[] = Passenger::where('national_code', $request_national_code)->first()->id;
        }

        //If there were common items between passengers at the user's request and travelers
        //This means that at least one of the passengers has been registered as a user in the past and passengers will not be asked for validation
        //Otherwise they are validated
        if (count(array_intersect($trip_passengers, $request_passengers)) != 0) {

            $common_ids = array_intersect($trip_passengers, $request_passengers);
            $common_national_codes = [];

            foreach ($common_ids as $common_id) {
                $common_national_codes[] = Passenger::find($common_id)->national_code;
            }
            $this->common_national_codes = $common_national_codes;
            return false;
        } else {
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
        return 'national codes: ' . implode(", ", $this->common_national_codes) . ' are there in this trip';
    }
}
