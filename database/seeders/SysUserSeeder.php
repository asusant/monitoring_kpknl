<?php

namespace Database\Seeders;

use App\Models\SysUser;
use Illuminate\Database\Seeder;

class SysUserSeeder extends Seeder
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
                'username_user' => 'hendi',
                'email_user'    => 'hendi@mail.com',
                'nm_user'       => 'Hendi',
                'password_user' => bcrypt('susanto'),
                'identitas_user'=> '100001',
                'is_aktif'      => 1,
                'created_by'    => 1
            ],
            [
                'id_user'       => 2,
                'username_user' => 'admin',
                'email_user'    => 'admin@mail.com',
                'nm_user'       => 'Admin',
                'password_user' => bcrypt('password'),
                'identitas_user'=> '100002',
                'is_aktif'      => 1,
                'created_by'    => 1
            ],
        ];

        SysUser::insert($dt);
    }
}
