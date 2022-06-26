<?php

namespace App\Modules\MonitoringKpkNl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class TimPenilaian extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'tim_penilaian';
    protected $primaryKey = 'id_tim_penilaian';
    protected $fillable = ['id_user_tim_penilaian', 'nm_tim_penilaian', 'nip_tim_penilaian', 'is_aktif', 'created_by', 'updated_by', 'deleted_by'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'id_user_tim_penilaian' => 'required|numeric',
	        'nm_tim_penilaian' 	    => 'required|string|max:192',
	        'nip_tim_penilaian' 	=> 'required|numeric|min:1|digits_between:10,20',
            'urutan_tim_penilaian'  => 'required|numeric|min:0',
	        'is_aktif' 	            => 'required|in:0,1'
        ];
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getData($limit)
    {
        return self::join('sys_user', 'id_user_tim_penilaian', 'id_user')
            ->select(DB::raw('CONCAT(nm_user, " (", email_user, ")") as user_tim_penilaian'), $this->table.'.*')
            ->paginate($limit);
    }

}
