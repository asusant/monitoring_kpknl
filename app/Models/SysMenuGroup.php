<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SysMenuGroup extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'sys_menu_group';
	protected $primaryKey = 'id_menu_group';
    protected $fillable = ['nm_menu_group', 'urutan', 'created_by', 'updated_by', 'deleted_by'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'nm_menu_group' => 'required|string|max:50',
            'urutan'        => 'required|numeric|min:1'
        ];
    }
}
