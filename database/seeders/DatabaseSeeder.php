<?php

namespace Database\Seeders;

use App\Models\SysPrivilege;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AppSettingSeeder::class,
            SysMenuGroupSeeder::class,
            SysModulGroupSeeder::class,
            SysModulSeeder::class,
            SysRoleSeeder::class,
            SysPrivilegeSeeder::class,
            SysSettingSeeder::class,
            SysUserSeeder::class,
            SysUserRoleSeeder::class
        ]);
    }
}
