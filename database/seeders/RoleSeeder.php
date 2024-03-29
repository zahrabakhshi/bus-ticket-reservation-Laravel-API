<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name'=> 'super-user'],
            ['name'=> 'admin'],
            ['name'=> 'company'],
            ['name'=> 'user']
        ];
        foreach ($roles as $role){
            Role::create($role);
        }
    }
}
