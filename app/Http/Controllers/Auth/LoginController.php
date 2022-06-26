<?php

namespace App\Http\Controllers\Auth;

use App\Bobb\Libs\BApp;
use App\Models\SysUser;
use App\Bobb\Services\BAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sikeu\User as UserSikeu;

class LoginController extends Controller
{

    protected $login_redirect = 'dashboard.read';
    protected $login_route = 'auth.login.view';

    public function index()
    {
        return view("auth.login");
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        $login = (new BAuth)->login($request->email, $request->password);

        if(!$login['status'])
        {
            return redirect()->route($this->login_route)->withInput()->withErrors($login['message']);
        }

        return redirect()->route($this->login_redirect)->with("success", $login['message']);
    }

    public function logout()
    {
        (new BAuth)->logout();

        return redirect()->route($this->login_route);
    }

    public function ssoLogin()
    {
        return view('auth/sso-login');
    }

    public function doSsoLogin(Request $request)
    {
        // ambil data POST dari form
        $data['sso_token'] = $request->input('sso_token');

        // call API with CURL method
        $result = (new BApp)->callApi('apps','auth',$data);

        if($result['success'])
        {
            $data = $result['data']['data'];

            // cek user sikeu
            $userSikeu = UserSikeu::getUser($data['kodeidentitas']);
            $identitas = $data['kodeidentitas'];

            if(sizeof($userSikeu) > 0)
            {
                $usRow = $userSikeu->first();
            }
            else
            {
                // cek lagi di RPD
                $cek = SysUser::where('identitas_user', $data['kodeidentitas'])->first();
                if(!$cek)
                {
                    return abort('403', 'Anda tidak memiliki akses di sistem ini.');
                }
            }

            // cek local
            $local = SysUser::where('identitas_user', $identitas)->first();

            if(!$local)
            {
                // add user
                $local = new SysUser;
                $local->nm_user = $usRow->user_nama;
                $local->username_user = $usRow->user_username;
                $local->identitas_user = $usRow->user_nip;
                $local->is_aktif = 1;
                $local->created_by = 0;
                $local->save();
            }

            // (new BAuth)->syncUnitSikeu($local);

            (new BAuth)->login('','',$local);

            // session is_sso untuk menandakan login by sso
            session()->put('is_sso', true);

            // redirect ke dashboard admin page
            return redirect()->route($this->login_redirect)->with("success", "Login berhasil.");
        }
        else
        {
            die("Invalid Token");
        }
    }

    public function ssoLogout()
    {
        (new BAuth)->logout();
        return view('auth/sso-logout');
    }

}
