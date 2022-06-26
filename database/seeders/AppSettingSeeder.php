<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dt = [
            [
                'key'           => 'app_logo',
                'content'       => 'favicon.ico'
            ],
            [
                'key'           => 'app_company_name',
                'content'       => 'PT. Bobb'
            ],
            [
                'key'           => 'app_company_desc',
                'content'       => 'Company for Bobb'
            ],
            [
                'key'           => 'app_company_address',
                'content'       => 'St. San Joseph'
            ],
            [
                'key'           => 'app_company_logo',
                'content'       => 'logo.png'
            ],
            [
                'key'           => 'app_year',
                'content'       => '2021'
            ],
            [
                'key'           => 'app_company_site',
                'content'       => 'https://hendi.web.id'
            ]
        ];

        AppSetting::insert($dt);
    }
}
