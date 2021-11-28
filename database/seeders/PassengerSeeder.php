<?php

namespace Database\Seeders;

use App\Models\Passenger;
use App\Models\Reserve;
use Illuminate\Database\Seeder;

class PassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            ['zahra', '1'],
            ['fatemeh', '1'],
            ['sara', '1'],
            ['saba', '1'],
            ['mahnoosh', '1'],
            ['javid', '0'],
            ['reza', '0'],
            ['yasin', '0']
        ];
        $last_names = ['javadi', 'modradi', 'parsa', 'meibodi', 'yoosefi'];

        $national_codes = [];

        for ($i = 0; $i < 10; $i++) {

            $random_person = collect($names)->random();
            $name = $random_person[0];
            $gender = $random_person[1];
            $last_name = collect($last_names)->random();

            do{
                $tmp_national_code = rand(pow(10, 9), pow(10, 10) - 1);
            }while(array_search($tmp_national_code , $national_codes));

//            dd($gender);
            $national_codes[] = $tmp_national_code;

            $passengers[] = [
                'name' => $name,
                'last_name' => $last_name,
                'national_code' => $tmp_national_code,
                'gender' => "$gender",
            ];
        }

        foreach ($passengers as $passenger){
            Passenger::create($passenger);
        }
    }
}
