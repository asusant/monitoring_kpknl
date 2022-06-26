<?php

namespace App\Modules\MonitoringKpkNl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class TahapMonitoring extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'tahap_monitoring';
    protected $primaryKey = 'id_tahap';
    protected $fillable = ['nm_tahap', 'deadline_hari', 'deadline_jam', 'urutan_tahap', 'jns_tahap', 'ext_form_route', 'is_aktif', 'id_role_tahap', 'created_by', 'updated_by', 'deleted_by'];
    public $ref_jns_tahap = [
        'confirm'   => 'Konfirmasi',
        'form'      => 'Pengisian Form',
        'print'     => 'Cetak'
    ];

    public static function validation_data($update_id = "NULL") {
        return [
	        'nm_tahap' 	        => 'required|string|max:192',
	        'deadline_hari' 	=> 'required_without:deadline_jam|numeric',
            'deadline_jam'      => 'required_without:deadline_hari|numeric',
            'urutan_tahap'      => 'required|numeric|min:0',
            'jns_tahap'         => 'required|in:'.implode(",", array_keys((new self)->ref_jns_tahap)),
            'ext_form_route'    => 'required_if:jns_tahap,form,print',
	        'id_role_tahap'     => 'required',
	        'is_aktif'          => 'required|in:0,1'
        ];
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getData($limit)
    {
        return self::select($this->table.'.*', DB::raw('CONCAT(deadline_hari, " Hari ", deadline_jam, " Jam") as deadline'), 'nm_role as role_tahap')
            ->join('sys_role', 'id_role_tahap', 'id_role')
            ->paginate($limit);
    }

    public function getMapRoleTahap()
    {
        return self::where('is_aktif', 1)->pluck('id_role_tahap', 'urutan_tahap')->toArray();
    }

    public function getNextTahap($id_tahap)
    {
        $tahap = TahapMonitoring::find($id_tahap);
        if(!$tahap)
        {
            return NULL;
        }
        // next
        $next = TahapMonitoring::where('urutan_tahap', $tahap->urutan_tahap+1)->first();
        return $next;
    }
}
