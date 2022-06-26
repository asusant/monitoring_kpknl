<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SysUserRole extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'sys_user_role';
	protected $primaryKey = 'id_user_role';
    protected $fillable = ['id_user', 'id_role', 'created_by', 'updated_by', 'deleted_by'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'id_user' 	    => 'required|exists:sys_user,id_user',
	        'id_role' 	    => 'required|exists:sys_role,id_role'
        ];
    }
}
