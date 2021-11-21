<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Town;
use App\Models\Trip;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->generateData();

        foreach ($data as $trip) {
            DB::transaction(function () use ($trip) {


                //We have trip and location tables. we have to set records in them

                //Generate a trip
                $new_trip = Trip::create(['vehicle_id' => $trip['vehicle_id']]);

                //Generate timestamps for start and end locations
                $start_time_hit = $trip['start_time'];
                $end_time_hit = $trip['end_time'];

                //Generate start and end locations
                $start_location_data = [
                    'trip_id' => $new_trip->id,
                    'time_hit' => $start_time_hit,
                    'type' => 'start_loc',
                    'town_id' => $trip['origin_town_id'],
                ];

                $end_location_data = [
                    'trip_id' => $new_trip->id,
                    'time_hit' => $end_time_hit,
                    'type' => 'end_loc',
                    'town_id' => $trip['destination_town_id'],
                ];

                Location::create($start_location_data);
                Location::create($end_location_data);

            });
        }
    }

    public function generateData()
    {

        $start_trips_duration = Carbon::now()->startOfDay()->addHours(6);
        $end_trips_duration = Carbon::now()->startOfDay()->addHours(6)->addMonths();

        for ($i = 0; $i < 10; $i++) {

            $dates = $this->generateRandomDates($start_trips_duration->timestamp, $end_trips_duration->timestamp);

            $origin_town_id = Town::all()->random()->id;

            $data[] =
                [
                    'vehicle_id' => Vehicle::all()->random()->id,
                    'start_time' => $dates->start_time,
                    'end_time' => $dates->end_time,
                    'origin_town_id' => Town::all()->random()->id,
                    'destination_town_id' => Town::whereNotIn('id', [$origin_town_id])->get()->random()->id,
                ];

        }

        return $data;
    }

    public function generateRandomDates($start_date, $end_date)
    {


        // Generate random number using above bounds
        $val = rand($start_date, $end_date);

        // Convert back to date
        return json_decode(json_encode([
            'start_time' => Carbon::createFromTimestamp($val)->startOfHour()->timestamp,
            'end_time' => Carbon::createFromTimestamp($val)->startOfHour()->addHours(rand(2, 20))->timestamp,
        ]));

    }
}
