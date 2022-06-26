<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysLog extends Model
{
    use HasFactory;
	protected $table = 'sys_log';
	protected $primaryKey = 'id_sys_log';
    protected $fillable = ['kegiatan', 'data_a', 'data_b'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'nm_role'   => 'required|string|max:50',
			'ket_role'  => 'required|string|max:192'
        ];
    }
}
