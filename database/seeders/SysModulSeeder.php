<?php

namespace Database\Seeders;

use App\Models\SysModul;
use Illuminate\Database\Seeder;

class SysModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $module = [
            [
                'id_modul_group'    => 1,
                'nm_modul'          => 'Menu Group',
                'route_prefix'      => 'sys_menu_group',
                'urutan'            => 1,
                'is_tampil'         => 1,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 1,
                'nm_modul'          => 'Module Group',
                'route_prefix'      => 'sys_module_group',
                'urutan'            => 2,
                'is_tampil'         => 1,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 1,
                'nm_modul'          => 'Module',
                'route_prefix'      => 'sys_module',
                'urutan'            => 3,
                'is_tampil'         => 1,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 2,
                'nm_modul'          => 'System Setting',
                'route_prefix'      => 'sys_setting',
                'urutan'            => 1,
                'is_tampil'         => 1,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 3,
                'nm_modul'          => 'Role User',
                'route_prefix'      => 'sys_role',
                'urutan'            => 1,
                'is_tampil'         => 1,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 3,
                'nm_modul'          => 'App Setting',
                'route_prefix'      => 'app_setting',
                'urutan'            => 1,
                'is_tampil'         => 1,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 4,
                'nm_modul'          => 'User',
                'route_prefix'      => 'sys_user',
                'urutan'            => 1,
                'is_tampil'         => 1,
                'created_by'        => 1
            ],
            [
                'id_modul_group'    => 4,
                'nm_modul'          => 'User Role',
                'route_prefix'      => 'sys_user_role',
                'urutan'            => 2,
                'is_tampil'         => 0,
                'created_by'        => 1
            ],
        ];

        SysModul::insert($module);
    }
}
