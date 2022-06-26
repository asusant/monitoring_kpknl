<?php

namespace App\Bobb\Libs;

use App\Models\SysLog;
use App\Models\SysEmail;
use Illuminate\Support\Facades\Auth;
use App\Bobb\Services\BAuth;
use DB;
use Form;

class BApp
{

    /**
	 * log function.
	 *
	 * @access public
	 * @param mixed $kegiatan
	 * @return void
	 */
	public static function log($kegiatan,$data_a = null,$data_b = null)
	{
        $log = new SysLog;
        $log->id_user = Auth::user()->id_user;
        $log->user_name = Auth::user()->nm_user;
        $log->ip_address = $_SERVER['REMOTE_ADDR'];
        $log->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $log->kegiatan = $kegiatan;
        $log->data_a = json_encode($data_a);
        $log->data_b = json_encode($data_b);
        $log->created_at = date('Y-m-d H:i:s');
        $log->save();
	}

	/**
	 * queueEmail function.
	 *
	 * @access public
	 * @param mixed $to
	 * @param mixed $name
	 * @param mixed $subject
	 * @param mixed $content
	 * @param string $attach (default: '')
	 * @return void
	 */
	public function queueEmail($to,$name,$subject,$content)
	{
        $d = new SysEmail;
        $d->to = $to;
        $d->name = $name;
        $d->subject = $subject;
        $d->content = $content;
        $d->created_at = date('Y-m-d H:i:s');
        $d->save();
	}


	/**
	 * callApi function.
	 *
	 * @access public
	 * @param mixed $url
	 * @param bool $data (default: false)
	 * @return void
	 */
	public function callApi($api,$url,$data=false)
	{
		$cnf = config('bapp.api')[$api];
		$username = $cnf['username'];
		$password = $cnf['password'];
		$baseurl = $cnf['base_url'];
		$process = curl_init();
		$url = $baseurl.$url;
		curl_setopt($process, CURLOPT_URL, $url);
		curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);

		if(is_array($data))
		{
			$data = http_build_query($data);
			curl_setopt($process, CURLOPT_POST, 1);
			curl_setopt($process, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);

		return json_decode($return,true);
	}

	/**
	 * strRandom function.
	 *
	 * @access public
	 * @param int $length (default: 6)
	 * @return void
	 */
	public function strRandom($length = 6)
	{
		$str = "";
		$characters = str_split('ABCDEFGHJKMNPQRSTUVWXYZabcdefghjmnpqrstuvwxyz123456789');
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++)
		{
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}

	public function countOnlineUser()
	{
		return \DB::table('sessions')
			->whereNotNull('user_id')
			->where(DB::raw('UNIX_TIMESTAMP()-last_activity'),'<=',300)
			->count();
    }

    /**
     * generate submit button with spinner
     *
     * @param [type] $txt
     * @param [type] $type
     * @param string $class
     * @param string $add
     * @return void
     */
    public function submitBtn($txt, $type='primary', $class = '', $addElm = '')
    {
        return '<button type="button" class="btn btn-'.$type.' me-1 mb-1 btn-submit '.$class.'" '.$addElm.'>
            <span class="spinner-border spinner-border-sm loading-spinner" role="status" aria-hidden="true" style="display:none;"></span>
            '.$txt.'
        </button>';
    }

    /**
     * Button Akses
     *
     * @param [type] $route_prefix
     * @param [type] $id
     * @param array $except
     * @param string $addClass
     * @return void
     */
    public function btnAkses($route_prefix, $id, $except = array(), $addClass = '')
    {
        $akses = config('bobb.akses');
        $ret = '';
        if (!in_array('update', $except) && $akses['a_update'] == 1)
        {
            $ret .= ' '.link_to(route($route_prefix.'.edit', ['id' => $id]), 'Edit', ['class' => 'btn btn-secondary '.$addClass]);
        }
        if (!in_array('delete', $except) && $akses['a_delete'] == 1)
        {
            $ret .= ' '.Form::button('Hapus', ['class' => 'btn btn-danger '.$addClass, 'onclick' => 'confirmDelete("'.route($route_prefix.'.delete', ['id' => $id]).'")']);
        }
        if (!in_array('validate', $except) && $akses['a_validate'] == 1)
        {
            $ret .= ' '.link_to(route($route_prefix.'.validate', ['id' => $id]), 'Validate', ['class' => 'btn btn-info '.$addClass]);
        }

        return $ret;
    }

    public function btnConfirm($txt, $url, $msgTxt='', $addClass='', $callback='')
    {
        return Form::button($txt, ['class' => 'btn btn-danger '.$addClass, 'onclick' => 'confirmAction("'.$url.'", "'.$msgTxt.'", "Yakin", "Tidak", '.$callback.')']);
    }

}
