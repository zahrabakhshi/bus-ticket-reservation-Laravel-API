<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('123');
        $users = [
            [
                'name' => 'Zahra',
                'last_name' => 'Bakhshi',
                'email' => 'zahra.b_1997@gmail.com',
                'password' => "$password",
                'gender' => 'women',
                'phone_number' => '09392086303',
                'national_code' => '4580296176',
                'card_number' => '6037997400000000',
            ],
            [
                'email' => 'shainy.i76@gmail.com',
                'password' => "$password",
            ],
        ];
        foreach ($users as $user){
            User::create($user);
        }
    }
}
