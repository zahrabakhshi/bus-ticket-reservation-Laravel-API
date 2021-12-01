<?php

namespace App\Http\Requests;

use App\Http\Controllers\API\FreeSeats;
use App\Rules\SeatsAvailable;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Console\Input\Input;

class TemporaryReserveRequest extends FormRequest
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
            'trip_id' => 'required|exists:trips,id',
            'seats_number.*' => [ "required", "integer", new SeatsAvailable(),]
        ];
    }


}
