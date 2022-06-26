<?php

namespace Database\Seeders;

use App\Models\SysRole;
use Illuminate\Database\Seeder;

class SysRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sys_role = [
            [
                'id_role'           => 1,
                'nm_role'           => 'Root',
                'ket_role'          => 'Developer Only',
                'created_by'        => 1
            ],
            [
                'id_role'           => 2,
                'nm_role'           => 'Admin',
                'ket_role'          => 'Admin Aplikasi',
                'created_by'        => 1
            ],
        ];

        SysRole::insert($sys_role);
    }
}
