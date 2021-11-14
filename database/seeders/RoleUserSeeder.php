<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            if($user->email == 'super@super'){
                $user->roles()->attach(Role::select('id')->where('name','super-user')->get());
            }elseif ($user->email == 'admin@admin'){
                $user->roles()->attach(Role::select('id')->where('name','admin')->get() );
            }elseif ($user->email == 'company@company'){
                $user->roles()->attach(Role::select('id')->where('name','company')->get() );
            }
        }
    }
}
