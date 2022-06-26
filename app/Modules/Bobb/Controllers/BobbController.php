<?php

namespace App\Modules\Bobb\Controllers;

use App\Bobb\Libs\BApp;
use App\Models\SysRole;
use App\Models\SysUser;
use App\Models\SysModul;
use App\Models\AppSetting;
use App\Models\SysSetting;
use App\Bobb\Services\BAuth;
use App\Models\SysMenuGroup;
use Illuminate\Http\Request;
use App\Models\SysModulGroup;
use App\Http\Controllers\Controller;
use App\Models\SysUserRole;
use Illuminate\Support\Facades\Auth;

class BobbController extends Controller
{
    //
    public function index()
    {
        $data = array();
        return view('Bobb::home.index', $data);
    }

    public function changeRole($role, $unit=null)
    {
        $bAuth = new BAuth;
        // cek apakah punya?
        $roles = $bAuth->getUserRole(false);
        if($unit)
        {
            $cek = $roles->where('id_role', $role)->where('unit_sikeu', $unit)->first();
        }
        else
        {
            $cek = $roles->where('id_role', $role)->first();
        }

        if(!$cek)
        {
            return redirect(route($bAuth->login_redirect))->with('alert', ['danger', 'Anda tidak berhak mengubah role!']);
        }
        else
        {
            $bAuth->setActiveRole($role, $cek->unit_sikeu, true);
        }

        return redirect(route($bAuth->login_redirect))->with('alert', ['success', 'Berhasil mengubah Role!']);
    }

    /* ---------------------------------------------
    *  -------------- SYS SETTING
    *  --------------------------------------------- */

    public function sysSettingIndex()
    {
        $data['data'] = SysSetting::orderBy('key')->get();
        return view('Bobb::syssetting.index', $data);
    }

    public function sysSettingCreate(Request $req)
    {
        $this->validate($req, SysSetting::validation_data());

        $dt = new SysSetting();
		foreach (SysSetting::validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        BApp::log('Menambah data app_setting. id='.$dt->id_sys_setting.'.', $req->except('_token'));
        return redirect()->back()->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    public function sysSettingUpdate(Request $req)
    {
        $fail = 0;
        $updated = 0;
        $user_id = Auth::user()->id_user;
        foreach ($req->input('content') as $id => $val)
        {
            $old = SysSetting::find($id);
            if(!$old)
            {
                $fail++;
            }
            else
            {
                if($val != $old->content)
                {
                    $old->content = $val;
                    $old->updated_by = $user_id;

                    BApp::log('Mengubah data app_setting. id='.$old->id_sys_setting.'.', $old->getOriginal(), $old->getAttributes());

                    $old->save();
                    $updated++;
                }
            }
        }
        return redirect()->back()->with('alert', ['success', $updated.' data berhasil diubah!']);
    }

    /* ---------------------------------------------
    *  -------------- APP SETTING
    *  --------------------------------------------- */

    public function appSettingIndex()
    {
        $data['data'] = AppSetting::orderBy('key')->get();
        return view('Bobb::appsetting.index', $data);
    }

    public function appSettingCreate(Request $req)
    {
        $this->validate($req, AppSetting::validation_data());

        $dt = new AppSetting();
		foreach (AppSetting::validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        BApp::log('Menambah data app_setting. id='.$dt->id_app_setting.'.', $req->except('_token'));
        return redirect()->back()->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    public function appSettingUpdate(Request $req)
    {
        $fail = 0;
        $updated = 0;
        $user_id = Auth::user()->id_user;
        foreach ($req->input('content') as $id => $val)
        {
            $old = AppSetting::find($id);
            if(!$old)
            {
                $fail++;
            }
            else
            {
                if($val != $old->content)
                {
                    $old->content = $val;
                    $old->updated_by = $user_id;

                    BApp::log('Mengubah data app_setting. id='.$old->id_app_setting.'.', $old->getOriginal(), $old->getAttributes());

                    $old->save();
                    $updated++;
                }
            }
        }
        return redirect()->back()->with('alert', ['success', $updated.' data berhasil diubah!']);
    }

    /* ---------------------------------------------
    *  -------------- SYS ROLE
    *  --------------------------------------------- */

    public function sysRoleIndex()
    {
        $data['data'] = SysRole::orderBy('id_role')->get();
        return view('Bobb::sysrole.index', $data);
    }

    public function sysRoleCreate()
    {
        $data['data'] = [];
        $data['form_route'] = ['sys_role.store'];
        return view('Bobb::sysrole.form', $data);
    }

    public function sysRoleEdit($id)
    {
        $data['data'] = SysRole::findOrFail($id);
        $data['form_route'] = ['sys_role.update'];
        return view('Bobb::sysrole.form', $data);
    }

    public function sysRoleStore(Request $req)
    {
        $this->validate($req, SysRole::validation_data());

        $dt = new SysRole();
		foreach ($dt->validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        BApp::log('Menambah data Role User. id='.$dt->id_role.'.', $req->except('_token'));
        return redirect()->back()->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    public function sysRoleUpdate(Request $req)
    {
        $this->validate($req, SysRole::validation_data());

        $dt = SysRole::findOrFail($req->input('id_role'));
		foreach ($dt->validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
        $dt->updated_by = Auth::user()->id_user;

        BApp::log('Mengubah data Role User. id='.$dt->id_role.'.', $dt->getOriginal(), $req->except('_token'));
        $dt->save();
        return redirect()->back()->with('alert', ['success', 'Data berhasil diubah!']);
    }

    public function sysRoleDelete($id)
    {
        $dt = SysRole::findOrFail($id);
        BApp::log('Menghapus data Role User. id='.$dt->id_role.'.', $dt->getAttributes());
        $dt->deleted_by = Auth::user()->id_user;
        $dt->save();
        $dt->delete();

        return redirect()->back()->with('alert', ['success', 'Data berhasil dihapus!']);
    }

    /* ---------------------------------------------
    *  -------------- SYS MENU GROUP
    *  --------------------------------------------- */

    public function sysMenuGroupIndex()
    {
        $data['data'] = SysMenuGroup::orderBy('urutan')->get();
        return view('Bobb::sysmenugroup.index', $data);
    }

    public function sysMenuGroupCreate()
    {
        $data['data'] = [];
        $data['form_route'] = ['sys_menu_group.store'];
        return view('Bobb::sysmenugroup.form', $data);
    }

    public function sysMenuGroupEdit($id)
    {
        $data['data'] = SysMenuGroup::findOrFail($id);
        $data['form_route'] = ['sys_menu_group.update'];
        return view('Bobb::sysmenugroup.form', $data);
    }

    public function sysMenuGroupStore(Request $req)
    {
        $this->validate($req, SysMenuGroup::validation_data());

        $dt = new SysMenuGroup();
		foreach ($dt->validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        BApp::log('Menambah data Grup Menu. id='.$dt->id_menu_group.'.', $req->except('_token'));
        return redirect()->back()->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    public function sysMenuGroupUpdate(Request $req)
    {
        $this->validate($req, SysMenuGroup::validation_data());

        $dt = SysMenuGroup::findOrFail($req->input('id_menu_group'));
		foreach ($dt->validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
        $dt->updated_by = Auth::user()->id_user;

        BApp::log('Mengubah data Grup Menu. id='.$dt->id_menu_group.'.', $dt->getOriginal(), $req->except('_token'));
        $dt->save();
        return redirect()->back()->with('alert', ['success', 'Data berhasil diubah!']);
    }

    public function sysMenuGroupDelete($id)
    {
        $dt = SysMenuGroup::findOrFail($id);
        BApp::log('Menghapus data Grup Menu. id='.$dt->id_menu_group.'.', $dt->getAttributes());
        $dt->deleted_by = Auth::user()->id_user;
        $dt->save();
        $dt->delete();

        return redirect()->back()->with('alert', ['success', 'Data berhasil dihapus!']);
    }

    /* ---------------------------------------------
    *  -------------- SYS MODULE GROUP
    *  --------------------------------------------- */

    public function sysModuleGroupIndex($id_menu)
    {
        $data['menu_group'] = SysMenuGroup::findOrFail($id_menu);
        $data['data'] = SysModulGroup::where('id_menu_group', $id_menu)->orderBy('urutan')->get();
        return view('Bobb::sysmodulegroup.index', $data);
    }

    public function sysModuleGroupCreate($id_menu)
    {
        $data['data'] = [];
        $data['menu_group'] = SysMenuGroup::findOrFail($id_menu);
        $data['form_route'] = ['sys_module_group.store'];
        return view('Bobb::sysmodulegroup.form', $data);
    }

    public function sysModuleGroupEdit($id)
    {
        $data['data'] = SysModulGroup::findOrFail($id);
        $data['menu_group'] = SysMenuGroup::findOrFail($data['data']->id_menu_group);
        $data['form_route'] = ['sys_module_group.update'];
        return view('Bobb::sysmodulegroup.form', $data);
    }

    public function sysModuleGroupStore(Request $req)
    {
        $this->validate($req, SysModulGroup::validation_data());

        $dt = new SysModulGroup();
		foreach ($dt->validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        BApp::log('Menambah data Modul Grup. id='.$dt->id_modul_group.'.', $req->except('_token'));
        return redirect()->back()->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    public function sysModuleGroupUpdate(Request $req)
    {
        $this->validate($req, SysModulGroup::validation_data());

        $dt = SysModulGroup::findOrFail($req->input('id_modul_group'));
		foreach ($dt->validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
        $dt->updated_by = Auth::user()->id_user;

        BApp::log('Mengubah data Grup Modul. id='.$dt->id_modul_group.'.', $dt->getOriginal(), $req->except('_token'));
        $dt->save();
        return redirect()->back()->with('alert', ['success', 'Data berhasil diubah!']);
    }

    public function sysModuleGroupDelete($id)
    {
        $dt = SysModulGroup::findOrFail($id);
        BApp::log('Menghapus data Group Modul. id='.$dt->id_modul_group.'.', $dt->getAttributes());
        $dt->deleted_by = Auth::user()->id_user;
        $dt->save();
        $dt->delete();

        return redirect()->back()->with('alert', ['success', 'Data berhasil dihapus!']);
    }

    /* ---------------------------------------------
    *  -------------- SYS MODULE
    *  --------------------------------------------- */

    public function sysModuleIndex($id_modul)
    {
        $data['modul_group'] = SysModulGroup::findOrFail($id_modul);
        $data['data'] = SysModul::where('id_modul_group', $id_modul)->orderBy('urutan')->get();
        return view('Bobb::sysmodule.index', $data);
    }

    public function sysModuleCreate($id_modul)
    {
        $data['data'] = [];
        $data['modul_group'] = SysModulGroup::findOrFail($id_modul);
        $data['form_route'] = ['sys_module.store'];
        return view('Bobb::sysmodule.form', $data);
    }

    public function sysModuleEdit($id)
    {
        $data['data'] = SysModul::findOrFail($id);
        $data['modul_group'] = SysModulGroup::findOrFail($data['data']->id_modul_group);
        $data['form_route'] = ['sys_module.update'];
        return view('Bobb::sysmodule.form', $data);
    }

    public function sysModuleStore(Request $req)
    {
        $this->validate($req, SysModul::validation_data());

        $dt = new SysModul();
		foreach ($dt->validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        BApp::log('Menambah data Modul. id='.$dt->id_modul.'.', $req->except('_token'));
        return redirect()->back()->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    public function sysModuleUpdate(Request $req)
    {
        $this->validate($req, SysModul::validation_data($req->input('id_modul')));

        $dt = SysModul::findOrFail($req->input('id_modul'));
		foreach ($dt->validation_data() as $col => $rule)
		{
			$dt->{$col} = $req->input($col);
		}
        $dt->updated_by = Auth::user()->id_user;

        BApp::log('Mengubah data Modul. id='.$dt->id_modul.'.', $dt->getOriginal(), $req->except('_token'));
        $dt->save();
        return redirect()->back()->with('alert', ['success', 'Data berhasil diubah!']);
    }

    public function sysModuleDelete($id)
    {
        $dt = SysModul::findOrFail($id);
        BApp::log('Menghapus data Modul. id='.$dt->id_modul.'.', $dt->getAttributes());
        $dt->deleted_by = Auth::user()->id_user;
        $dt->save();
        $dt->delete();

        return redirect()->back()->with('alert', ['success', 'Data berhasil dihapus!']);
    }

    /* ---------------------------------------------
    *  -------------- SYS USER
    *  --------------------------------------------- */

    public function sysUserIndex()
    {
        $data['data'] = SysUser::orderBy('nm_user')->paginate(25);
        return view('Bobb::sysuser.index', $data);
    }

    public function sysUserCreate()
    {
        $data['data'] = [];
        $data['form_route'] = ['sys_user.store'];
        return view('Bobb::sysuser.form', $data);
    }

    public function sysUserEdit($id)
    {
        $data['data'] = SysUser::findOrFail($id);
        $data['form_route'] = ['sys_user.update'];
        return view('Bobb::sysuser.form', $data);
    }

    public function sysUserStore(Request $req)
    {
        $this->validate($req, SysUser::validation_data());

        $dt = new SysUser();
		foreach ($dt->validation_data() as $col => $rule)
		{
            $dt->{$col} = $req->input($col);
        }
        $dt->password_user = bcrypt($req->input('password_user'));
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        BApp::log('Menambah data User. id='.$dt->id_user.'.', $req->except('_token'));
        return redirect()->back()->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    public function sysUserUpdate(Request $req)
    {
        $this->validate($req, SysUser::validation_data($req->input('id_user')));

        $dt = SysUser::findOrFail($req->input('id_user'));
		foreach ($dt->validation_data($req->input('id_user')) as $col => $rule)
		{
			if($req->input($col) != '')
            {
                $dt->{$col} = $req->input($col);
            }
        }
        if($req->input('password_user') && $req->input('password_user') != '')
        {
            $dt->password_user = bcrypt($req->input('password_user'));
        }
        $dt->updated_by = Auth::user()->id_user;

        BApp::log('Mengubah data User. id='.$dt->id_user.'.', $dt->getOriginal(), $req->except('_token'));
        $dt->save();
        return redirect()->back()->with('alert', ['success', 'Data berhasil diubah!']);
    }

    public function sysUserDelete($id)
    {
        $dt = SysUser::findOrFail($id);
        BApp::log('Menghapus data User. id='.$dt->id_user.'.', $dt->getAttributes());
        $dt->deleted_by = Auth::user()->id_user;
        $dt->save();
        $dt->delete();

        return redirect()->back()->with('alert', ['success', 'Data berhasil dihapus!']);
    }

    /* ---------------------------------------------
    *  -------------- SYS USER ROLE
    *  --------------------------------------------- */

    public function sysUserRoleIndex($id_user)
    {
        $data['data'] = SysUserRole::join('sys_role as b', 'sys_user_role.id_role', '=', 'b.id_role')
            ->join('sys_user as c', 'sys_user_role.id_user', '=', 'c.id_user')
            ->where('sys_user_role.id_user', $id_user)
            ->whereNull('b.deleted_at')
            ->whereNull('c.deleted_at')
            ->get();
        $data['user'] = SysUser::findOrFail($id_user);
        return view('Bobb::sysuserrole.index', $data);
    }

    public function sysUserRoleCreate($id_user)
    {
        $data['data'] = [];
        $data['user'] = SysUser::findOrFail($id_user);
        $data['ref_role'] = SysRole::get(['nm_role', 'id_role'])->pluck('nm_role', 'id_role')->toArray();
        $data['form_route'] = ['sys_user_role.store'];
        return view('Bobb::sysuserrole.form', $data);
    }

    public function sysUserRoleEdit($id)
    {
        $data['data'] = SysUserRole::findOrFail($id);
        $data['user'] = SysUser::findOrFail($data['data']->id_user);
        $data['ref_role'] = SysRole::get(['nm_role', 'id_role'])->pluck('nm_role', 'id_role')->toArray();
        $data['form_route'] = ['sys_user_role.update'];
        return view('Bobb::sysuserrole.form', $data);
    }

    public function sysUserRoleStore(Request $req)
    {
        $this->validate($req, SysUserRole::validation_data());

        $dt = new SysUserRole();
		foreach ($dt->validation_data() as $col => $rule)
		{
            $dt->{$col} = $req->input($col);
		}
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        BApp::log('Menambah data Role User. id='.$dt->id_user_role.'.', $req->except('_token'));
        return redirect()->back()->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    public function sysUserRoleUpdate(Request $req)
    {
        $this->validate($req, SysUserRole::validation_data($req->input('id_user_role')));

        $dt = SysUserRole::findOrFail($req->input('id_user_role'));
		foreach ($dt->validation_data($req->input('id_user_role')) as $col => $rule)
		{
			if($req->input($col) != '')
            {
                $dt->{$col} = $req->input($col);
            }
		}
        $dt->updated_by = Auth::user()->id_user;

        BApp::log('Mengubah data Role User. id='.$dt->id_user_role.'.', $dt->getOriginal(), $req->except('_token'));
        $dt->save();
        return redirect()->back()->with('alert', ['success', 'Data berhasil diubah!']);
    }

    public function sysUserRoleDelete($id)
    {
        $dt = SysUserRole::findOrFail($id);
        BApp::log('Menghapus data Role User. id='.$dt->id_user_role.'.', $dt->getAttributes());
        $dt->deleted_by = Auth::user()->id_user;
        $dt->save();
        $dt->delete();

        return redirect()->back()->with('alert', ['success', 'Data berhasil dihapus!']);
    }
}
