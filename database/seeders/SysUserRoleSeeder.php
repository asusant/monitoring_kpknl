<?php

namespace Database\Seeders;

use App\Models\SysUserRole;
use Illuminate\Database\Seeder;

class SysUserRoleSeeder extends Seeder
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
                'id_user'       => 1,
                'id_role'       => 1,
                'created_by'    => 1
            ],
            [
                'id_user'       => 1,
                'id_role'       => 2,
                'created_by'    => 1
            ],
            [
                'id_user'       => 2,
                'id_role'       => 2,
                'created_by'    => 1
            ],
        ];

        SysUserRole::insert($dt);
    }
}
