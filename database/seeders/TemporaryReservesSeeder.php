<?php

namespace Database\Seeders;

use App\Models\TemporaryReserve;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Http\Controllers\API\FreeSeats;

class TemporaryReservesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $temporary_reserves = [];

        for ($i = 0; $i < 10; $i++) {

            $trip_id = Trip::all()->random()->id;
            $free_seats = FreeSeats::findFreeSeats($trip_id);

            if (empty($free_seats)) {
                break;
            }

            $seats_count = rand(1, count($free_seats));
            $seats = collect($free_seats)->random($seats_count)->toArray();

            $json_seats = json_encode($seats);

            $temporary_reserves[$i] = [
                'user_id' => User::all()->random()->id,
                'trip_id' => $trip_id,
                'seats_json' => $json_seats,
            ];

            TemporaryReserve::create($temporary_reserves[$i]);

        }
    }
}
