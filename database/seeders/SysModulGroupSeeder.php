<?php

namespace Database\Seeders;

use App\Models\SysModulGroup;
use Illuminate\Database\Seeder;

class SysModulGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $module_group = [
            [
                'id_modul_group'    => 1,
                'id_menu_group'     => 1,
                'nm_modul_group'    => 'System Menu',
                'icon_modul_group'  => 'bi bi-menu-button-wide-fill',
                'urutan'            => 1,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 2,
                'id_menu_group'     => 1,
                'nm_modul_group'    => 'System Setting',
                'icon_modul_group'  => 'bi bi-gear-wide-connected',
                'urutan'            => 2,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 3,
                'id_menu_group'     => 2,
                'nm_modul_group'    => 'App Setting',
                'icon_modul_group'  => 'bi bi-gear-fill',
                'urutan'            => 1,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 4,
                'id_menu_group'     => 2,
                'nm_modul_group'    => 'User',
                'icon_modul_group'  => 'bi bi-person-badge-fill',
                'urutan'            => 2,
                'created_by'        => 1
            ],
        ];

        SysModulGroup::insert($module_group);
    }
}
