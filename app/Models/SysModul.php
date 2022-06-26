<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SysModul extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'sys_modul';
	protected $primaryKey = 'id_modul';
    protected $fillable = ['id_modul_group', 'route_prefix', 'nm_modul', 'icon_modul', 'urutan', 'is_tampil', 'created_by', 'updated_by', 'deleted_by'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'id_modul_group'    => 'required|exists:sys_modul_group,id_modul_group',
	        'nm_modul'          => 'required|string|max:100',
	        'urutan'            => 'required|numeric|min:1',
	        'is_tampil'         => 'required|boolean',
            'route_prefix' 	    => 'required|string|max:192|unique:sys_modul,route_prefix,'.$update_id.',id_modul,deleted_at,NULL'
        ];
    }
}
