<?php
namespace App\Bobb\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SysPrivilege;
use App\Models\SysUser;
use App\Models\SysUserRole;
use App\Models\Sikeu\User as UserSikeu;

class BAuth
{
    public $login_redirect = 'dashboard.read';
    public $login_route = 'auth.login.view';

    public function login($email, $password, $userModel = false)
    {
        $ret = ['status' => false, 'message' => 'Email atau Password Salah'];

        if($userModel)
        {
            $user = $userModel;
        }
        else
        {
            // login function
            $user = SysUser::where('email_user', $email)->first();
            if(!$user)
            {
                $user = false;
            }
            else if(!Hash::check($password, $user->password_user))
            {
                $user = false;
            }
        }

        if($user)
        {
            Auth::login($user);

            // $this->syncUnitSikeu($user);

            // Set additional session here
            $roles = $this->getUserRole(false);
            if(sizeof($roles) < 1)
            {
                $ret['message'] = 'Anda tidak memiliki role.';
                $this->logout();
            }
            else
            {
                $ret['status'] = true;
                $ret['message'] = "Login berhasil";
                $ret['user'] = Auth::user();
                $ret['roles'] = $roles;
                $ret['modules'] = $this->getModules();

                // Set Tahun
                $ret['tahun'] = $this->getTahunAktif(false);
                $ret['bulan'] = $this->getTahunAktif(false);
            }
        }

        return $ret;
    }

    public function logout($why=null)
    {
        Auth::logout();
        session()->flush();
    }

    public function getTahunAktif($use_session = true, $tahun = false)
    {
        if(!session()->has('bobb_active_tahun') || $use_session == false || $tahun)
		{
            $thn = date('Y');
            if($tahun)
            {
                $thn = $tahun;
            }
            session()->put('bobb_active_tahun', $thn);
        }

        return session()->get('bobb_active_tahun');
    }

    public function getBulanAktif($use_session = true, $bulan = false)
    {
        if(!session()->has('bobb_active_bulan') || $use_session == false || is_numeric($bulan))
		{
            $bln = date('n');
            if($bulan)
            {
                $bln = $bulan;
            }
            session()->put('bobb_active_bulan', $bln);
        }
        return session()->get('bobb_active_bulan');
    }

	public function getUserRole($use_session = true, $active_role = false)
	{
		if(!session()->has('bobb_user_roles') || $use_session == false)
		{
            $user = Auth::user();
            $roles = SysUserRole::join('sys_role as b', 'sys_user_role.id_role', '=', 'b.id_role')
                ->where('sys_user_role.id_user', $user->id_user)
                ->whereNull('b.deleted_at')
                ->get(['nm_role', 'b.id_role', 'unit']);

            if(sizeof($roles) > 0)
            {
                session()->put('bobb_user_roles', $roles);
                $r = $roles->first();
                $this->setActiveRole($r->id_role);
            }
            else
            {
                session()->put('bobb_user_roles', []);
            }
        }

        $role_s = session()->get('bobb_user_roles');
        if($active_role)
            $role_s = [session()->get('bobb_active_role')];

		return $role_s;
    }

    public function setActiveRole($id_role, $id_unit = null)
    {
        session()->put('bobb_active_role', $id_role);
        // $this->setUnitAktif($id_unit);
        $this->getModules(false);
        return true;
    }

	public function getModules($use_session = true, $arr_moudule = false)
	{
		if(!session()->has('bobb_modules') || $use_session == false)
		{
            $q = SysPrivilege::join('sys_modul as b', 'sys_privilege.id_modul', '=', 'b.id_modul')
                ->join('sys_modul_group as c', 'b.id_modul_group', '=', 'c.id_modul_group')
                ->join('sys_menu_group as d', 'c.id_menu_group', '=', 'd.id_menu_group')
                ->select(
                    'sys_privilege.*', 'b.*', 'c.nm_modul_group', 'c.icon_modul_group', 'd.nm_menu_group'
                )
                ->where('sys_privilege.id_role', session()->get('bobb_active_role'))
                ->whereNull('b.deleted_at')
                ->whereNull('c.deleted_at')
                ->whereNull('d.deleted_at')
                ->orderBy('d.urutan')
                ->orderBy('c.urutan')
                ->orderBy('b.urutan')
                ->get();

            $data = array(1 => array(), 2 => array());
            foreach ($q as $row)
            {
                if(!isset($data[1][$row->nm_menu_group]))
                    $data[1][$row->nm_menu_group] = array();
                if(!isset($data[1][$row->nm_menu_group][$row->nm_modul_group]))
                    $data[1][$row->nm_menu_group][$row->nm_modul_group] = array();

                if($row->is_tampil == 1 && $row->a_read == 1)
                    $data[1][$row->nm_menu_group][$row->nm_modul_group][] = $row;
                $data[2][$row->route_prefix] = $row->toArray();
            }

			session()->put('bobb_modules',$data);
		}

        $modules = session()->get('bobb_modules');

        if($arr_moudule)
        {
            return $modules[2];
        }

		return $modules;
    }

    public function cekAkses($route, $action, $obj = false)
    {
        $bypass_routes = ['frontend','dashboard','change_role','profile','logout'];

        $allow = false;
        if(!in_array($route,$bypass_routes))
        {
            // Ambil semua menu
            $modules = $this->getModules(false, true);

			// apakah ada di module?
			if(array_key_exists($route, $modules))
			{
                $module_check = $modules[$route];

                // mapping action route
                $map_action = config('bobb.map_privileges');
                foreach($map_action as $k => $v)
                {
                    if(in_array($action,$v))
                    {
                        $privileges = "a_".$k;
                    }
                }
                if(isset($privileges))
                {
                    if(isset($module_check[$privileges]))
                    {
                        if($module_check[$privileges] == 1)
                            $allow = true;
                    }
                }
			}
        }
        else
        {
            $allow = true;
        }

        if($obj)
        {
            $allow = [$allow];
            if(isset($module_check))
            {
                $allow[1] = $module_check;
            }
            else
            {
                $allow[1] = [];
            }
        }
		return $allow;
    }

    public function getUnitAktif($asli = false)
    {
        $unit = session()->get('bobb_active_unit');
        if(!$asli && session()->get('bobb_other_unit') && is_numeric(session()->get('bobb_other_unit')))
        {
            $unit = session()->get('bobb_other_unit');
        }
        return $unit;
    }

    public function setUnitAktif($unit)
    {
        session()->forget('bobb_other_unit');
        session()->put('bobb_active_unit', $unit);
    }

    // Set apabila ada pergantian unit
    public function setUnitLain($unit)
    {
        session()->put('bobb_other_unit', $unit);
    }

    public function syncUnitSikeu($user)
    {
        $map = UserSikeu::$mappingLevel;

        if($user->identitas_user)
        {
            // user sikeu
            $userSikeu = UserSikeu::getUser($user->identitas_user);

            // get role di RPD
            $userRole = SysUserRole::where('id_user', $user->id_user)->whereIn('id_role', array_keys($map))->get();

            // flip mapping untuk mempermudah
            $flipMap = array_flip($map);

            $insRole = [];
            foreach ($userSikeu as $i => $u)
            {
                // apakah sudah ada di role RPD?
                if( !$userRole->where('id_role', $flipMap[$u->level_id])->where('id_unit', $u->unit_kode)->first() )
                {
                    $insRole[$i]['id_user'] = $user->id_user;
                    $insRole[$i]['id_role'] = $flipMap[$u->level_id];
                    $insRole[$i]['unit'] = $u->unit_kode;
                    $insRole[$i]['created_by'] = 1;
                }
            }

            if(sizeof($insRole) > 0)
            {
                // insert ke user role jika masih ada yg belum termapping
                SysUserRole::insert($insRole);
            }
        }
    }

    public function getActiveRole()
    {
        return session()->get('bobb_active_role');
    }

}
