<?php

namespace Database\Seeders;

use App\Models\Reserve;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReserveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0 ; $i<5 ; $i++){
            $reserves = [
                'user_id' => User::all()->random()->id,
                'trip_id' => Trip::all()->random()->id,
            ];
            Reserve::create($reserves);
        }

    }
}
