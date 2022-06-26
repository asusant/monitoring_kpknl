<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SysSetting extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'sys_setting';
	protected $primaryKey = 'id_sys_setting';
    protected $fillable = ['key', 'content', 'created_by', 'updated_by', 'deleted_by'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'key' 	    => 'required|string|max:50|unique:app_setting,key,'.$update_id.',id_app_setting,deleted_at,NULL',
			'content' 	=> 'required|string'
        ];
    }
}
