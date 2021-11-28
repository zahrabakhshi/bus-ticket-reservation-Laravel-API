<?php

namespace Database\Seeders;

use App\Http\Controllers\API\FreeSeats;
use App\Models\Trip;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Reserve;
use App\Models\Passenger;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $reserves = Reserve::all();
        $busy_seats = [];
        foreach ($reserves as $reserve) {

            $trip = Trip::find($reserve->trip_id);

            $whole_capacity = FreeSeats::getWholeCapacity($trip->id);

            $remaining_capacity = FreeSeats::getFreeSeatsCount($trip->id);

            $seats_count = rand(1,$whole_capacity);

            $free_seats = FreeSeats::findFreeSeats($trip->id);

            if(empty($free_seats)){
                break;
            }


            for ($i = 0; $i < $seats_count; $i++) {//todo: ave to select random user between uesrs ont in this trip

                $rand_index = rand(0,1);

                $ticketable = [Passenger::all()->random(),User::all()->random()][$rand_index];

                $sit_number = collect($free_seats)->random();

                $sit_number_index = array_search($sit_number, $free_seats);

                unset($free_seats[$sit_number_index]);
                $seats_count --;

                $ticket = [
                    'seat_number' => $sit_number,
                    'reserve_id' => $reserve->id,
                ];
                $ticketable->tickets()->create($ticket);
            }

        }
    }
}
