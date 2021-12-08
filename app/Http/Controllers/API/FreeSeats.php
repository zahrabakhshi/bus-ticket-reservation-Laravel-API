<?php

namespace App\Http\Controllers\API;

use App\Models\TemporaryReserve;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Util\Exception;

class FreeSeats
{

    public static function findFreeSeats($trip_id)
    {
        $trip = Trip::find($trip_id);

        $reserved_seats = self::getReservedSeats($trip_id);
        $temporary_reserved_seats = self::getTemporaryReservedSeats($trip_id);

        if (!empty(array_intersect($temporary_reserved_seats, $reserved_seats))) {

            throw new Exception('in temporary reserves and reserves seats cause a conflict ');

        }

        $unavailable_seats = array_merge($temporary_reserved_seats, $reserved_seats);

        $all_seats = range(0, $trip->vehicle->capacity-1);
        $free_seats = array_values(array_diff($all_seats, $unavailable_seats));

        return $free_seats;

    }

    protected static function getReservedSeats($trip_id){

        $trip = Trip::find($trip_id);

        $tickets = $trip->tickets;

        return $tickets->pluck('seat_number')->toArray();
    }

    protected static function getTemporaryReservedSeats($trip_id){

        $temporary_reserved_array = [];

        if(TemporaryReserve::where('trip_id',$trip_id)->doesntExist()){
            return [];
        }

        foreach (TemporaryReserve::where('trip_id',$trip_id)->get(['seats_json','created_at','id']) as $item) {

            $c = new Carbon($item->created_at);
            if($c->addRealMinutes(15)->isPast()){

                TemporaryReserve::destroy($item->id);

            }else{

                $temporary_reserved = json_decode($item->seats_json,true);

                if(!empty(array_intersect($temporary_reserved_array,$temporary_reserved))){
                    throw new Exception('cause a conflict between temporary reserved arrays');
                }

                $temporary_reserved_array = array_merge($temporary_reserved_array, $temporary_reserved);

            }

            return $temporary_reserved_array;
        }

        return $temporary_reserved_array;

    }

    public static function getFreeSeatsCount($trip_id){

        $trip = Trip::find($trip_id);

        $tickets = $trip->tickets;
        return $tickets->count();

    }

    public static function getWholeCapacity($trip_id){

        return Trip::find($trip_id)->vehicle->capacity;

    }


}
