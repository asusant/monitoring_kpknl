<?php

namespace Database\Seeders;

use App\Models\SysSetting;
use Illuminate\Database\Seeder;

class SysSettingSeeder extends Seeder
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
                'key'           => 'sys_name',
                'content'       => 'Bobb'
            ],
            [
                'key'           => 'sys_desc',
                'content'       => 'Aplikasi untuk semua umat'
            ],
            [
                'key'           => 'sys_author_name',
                'content'       => 'Hendi'
            ],
            [
                'key'           => 'sys_author_link',
                'content'       => 'https://hendi.web.id'
            ],
        ];

        SysSetting::insert($dt);
    }
}
