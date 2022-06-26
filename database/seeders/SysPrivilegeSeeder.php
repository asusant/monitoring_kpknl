<?php

namespace Database\Seeders;

use App\Models\SysPrivilege;
use App\Models\SysRole;
use App\Models\SysModul;
use Illuminate\Database\Seeder;

class SysPrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = SysRole::all();
        $priv = [
            1   => [1,2,3,4],
            2   => [3,4]
        ];
        $ins = [];
        $i = 0;
        foreach ($role as $rl)
        {
            $modul = SysModul::whereIn('id_modul_group', $priv[$rl->id_role])->get();
            foreach ($modul as $m)
            {
                $ins[$i] = [
                    'id_modul'  => $m->id_modul,
                    'id_role'   => $rl->id_role,
                    'a_create'  => 1,
                    'a_read'    => 1,
                    'a_update'  => 1,
                    'a_delete'  => 1,
                    'a_validate'=> 1,
                    'created_by'=> 1
                ];
                $i++;
            }
        }
        SysPrivilege::insert($ins);
    }
}
