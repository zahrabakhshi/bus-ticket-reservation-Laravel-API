<?php

namespace Database\Seeders;

use App\Models\Town;
use Illuminate\Database\Seeder;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $towns = [
            [
                'name' => 'مشهد'
            ],[
                'name' => 'تهران'
            ],[
                'name' => 'اصفهان'
            ],[
                'name' => 'شاهرود'
            ],
        ];

        foreach ($towns as $town) {
            Town::create($town);
        }
    }
}
