<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicle_plates = [
            [
                'company_id' => Company::all()->random()->id,
                'plate' => '00-000-A-00',
                'capacity' => 25,
            ],
            [
                'company_id' => Company::all()->random()->id,
                'plate' => '11-111-B-11',
                'capacity' => 25,
            ],
            [
                'company_id' => Company::all()->random()->id,
                'plate' => '33-333-C-33',
                'capacity' => 25,
            ],
            [
                'company_id' => Company::all()->random()->id,
                'plate' => '44-444-D-44',
                'capacity' => 25,
            ],
        ];
        foreach ($vehicle_plates as $vehicle_plate) {
            Vehicle::create($vehicle_plate);
        }
    }
}
