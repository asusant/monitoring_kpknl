<?php

namespace App\Modules\MonitoringKpkNl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JnsPermohonan extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'jns_permohonan';
    protected $primaryKey = 'id_jns_permohonan';
    protected $fillable = ['nm_jns_permohonan', 'is_khusus', 'created_by', 'updated_by', 'deleted_by'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'nm_jns_permohonan' 	=> 'required|string|max:75',
	        'is_khusus' 	        => 'required|in:0,1',
	        'is_aktif' 	            => 'required|in:0,1'
        ];
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getForSelect($only_active = false)
    {
        $q = (new self)->select(
            'id_jns_permohonan',
            'nm_jns_permohonan'
        );
        if($only_active)
        {
            $q->where('is_aktif', 1);
        }
        $q->orderBy('nm_jns_permohonan');
        return $q->get()->pluck('nm_jns_permohonan', 'id_jns_permohonan')->toArray();
    }

}
