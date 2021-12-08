<?php

namespace App\Http\Requests;

use App\Rules\PassengerCountMatchesTemporaryReserveSeates;
use App\Rules\PassengerSeatsMatchTemporaryReservesSeats;
use App\Rules\SeatsAvailable;
use App\Rules\TemporayReserveOwner;
use App\Rules\uniquePassengerEveryTrip;
use Illuminate\Foundation\Http\FormRequest;

class ReserveStorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'temporary_reserve_id' => ['required','exists:temporary_reserves,id',new TemporayReserveOwner() ],
            'trip_id' => ['required', 'exists:trips,id', new uniquePassengerEveryTrip()],
            'passengers' => [new PassengerSeatsMatchTemporaryReservesSeats()],
            'passengers.*.national_code' => 'required|digits:10',
            'passengers.*.gender' => 'required|boolean',
            'passengers.*.name' => 'string|min:3|max:50',
            'passengers.*.last_name' => 'string|min:2|max:50',
            'passengers.*.seat_number' => [ "required", "integer", new SeatsAvailable(),]
        ];
    }
}
