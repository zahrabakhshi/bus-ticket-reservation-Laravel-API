<?php

namespace Database\Seeders;

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
        $roles_users = [];
        $role_id = 1;

        foreach (User::all() as $user) {
            $user->roles()->attach($role_id);
            $role_id++;
        }
    }
}
