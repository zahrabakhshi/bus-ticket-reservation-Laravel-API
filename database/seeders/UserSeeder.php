<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $password = Hash::make('12345678');
        $users_array = [
            [
                'email' => 'super@super',
                'password' => "$password",
            ],
            [
                'email' => 'admin@admin',
                'password' => "$password",
            ],
            [
                'email' => 'company@company',
                'password' => "$password",
            ],
            [
                'email' => 'user@user',
                'password' => "$password",
            ]
        ];
        foreach ($users_array as $user_data){
            $user = User::create($user_data);
            $user->roles()->attach(Role::select('id')->where('name','user')->get());
        }
    }
}
