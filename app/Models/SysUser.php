<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SysUser extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'sys_user';
	protected $primaryKey = 'id_user';
    protected $fillable = ['username_user', 'email_user', 'nm_user', 'password_user', 'identitas_user', 'is_aktif', 'created_by', 'updated_by', 'deleted_by'];
    protected $casts = [
        'identitas_user' => 'string',
    ];

    public static function validation_data($update_id = "NULL") {
        $pass = 'required';
        if($update_id != 'NULL')
        {
            $pass = 'nullable';
        }
        return [
	        'email_user'    => 'required|string|max:192|unique:sys_user,email_user,'.$update_id.',id_user,deleted_at,NULL',
	        'username_user' => 'required|string|max:192|unique:sys_user,username_user,'.$update_id.',id_user,deleted_at,NULL',
	        'nm_user' 	    => 'required|string|max:192',
			'password_user' => $pass.'|string|min:6',
			'identitas_user'=> 'required|string|max:50|unique:sys_user,identitas_user,'.$update_id.',id_user,deleted_at,NULL',
			'is_aktif'      => 'required|boolean'
        ];
    }
}
