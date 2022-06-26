<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SysModulGroup extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'sys_modul_group';
	protected $primaryKey = 'id_modul_group';
    protected $fillable = ['id_menu_group', 'route_prefix', 'nm_modul_group', 'icon_modul_group', 'urutan', 'created_by', 'updated_by', 'deleted_by'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'id_menu_group'     => 'required|exists:sys_menu_group,id_menu_group',
	        'nm_modul_group'    => 'required|string|max:100',
	        'icon_modul_group'  => 'required|string|max:50',
	        'urutan'            => 'required|numeric|min:1'
        ];
    }
}
