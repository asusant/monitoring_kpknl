<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SysRole extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'sys_role';
	protected $primaryKey = 'id_role';
    protected $fillable = ['nm_role', 'ket_role', 'created_by', 'updated_by', 'deleted_by'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'nm_role'   => 'required|string|max:50',
			'ket_role'  => 'required|string|max:192'
        ];
    }
}
