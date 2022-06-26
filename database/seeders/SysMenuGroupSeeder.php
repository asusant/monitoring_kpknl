<?php

namespace Database\Seeders;

use App\Models\SysMenuGroup;
use Illuminate\Database\Seeder;

class SysMenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu_group = [
            [
                'id_menu_group'     => 1,
                'nm_menu_group'    => 'System Setting',
                'urutan'            => 2,
                'created_by'        => 1
            ],
            [
                'id_menu_group'     => 2,
                'nm_menu_group'    => 'Application Setting',
                'urutan'            => 1,
                'created_by'        => 1
            ],
        ];

        SysMenuGroup::insert($menu_group);
    }
}
