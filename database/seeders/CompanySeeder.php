<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'name' => 'digikala',
                'registration_code' => '1054689523',
                'national_id' => '4587965858',
                'email' => 'info@digikala.com',
                'phone_number' => '02154896654',
            ],
            [
                'name' => 'turbogen',
                'registration_code' => '1054689524',
                'national_id' => '4587965859',
                'email' => 'info@turbogen.com',
                'phone_number' => '02154896655',
            ],
            [
                'name' => 'basalam',
                'registration_code' => '1054689525',
                'national_id' => '4587965860',
                'email' => 'info@basalam.com',
                'phone_number' => '02154896656',
            ],
            [
                'name' => 'snap',
                'registration_code' => '1054689526',
                'national_id' => '4587965861',
                'email' => 'info@snap.com',
                'phone_number' => '02154896657',
            ],
        ];

        foreach ($companies as $company){
            Company::create($company);
        }
    }
}
