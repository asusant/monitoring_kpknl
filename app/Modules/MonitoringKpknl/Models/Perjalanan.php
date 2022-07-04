<?php

namespace App\Modules\MonitoringKpkNl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perjalanan extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'perjalanan_permohonan';
    protected $primaryKey = 'id_perjalanan';
    protected $fillable = ['id_permohonan', 'id_tahap', 'wkt_mulai_perjalanan', 'sts_perjalanan', 'id_user_perjalanan', 'catatan', 'is_deadline_manual', 'next_deadline', 'created_by', 'updated_by', 'deleted_by'];

    public $ref_sts_perjalanan = [
        '0' => 'Menunggu diproses',
        '1' => 'Proses/Lanjut',
        '2' => 'Revisi',
    ];
    public $class_sts_perjalanan = [
        '0' => 'primary',
        '1' => 'success',
        '2' => 'danger'
    ];

    public static function validation_data($update_id = "NULL") {
        return [
            'id_permohonan'     => 'required|numeric',
            'sts_permohonan'    => 'required|in:0,1,2',
            'catatan'           => 'required_unless:sts_permohonan,1|max:192',
            'is_deadline_manual'=> 'required|in:0,1',
            'tgl_deadline'      => 'required_if:is_deadline_manual,1',
            'jam_deadline'      => 'required_if:is_deadline_manual,1'
        ];
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getPerjalanan($id_permohonan, $filters = [])
    {
        $t = $this->table;
        extract($filters);
        $q = self::leftJoin('sys_user as b', 'id_user_perjalanan', 'b.id_user')
            ->join('tahap_monitoring as c', $t.'.id_tahap', 'c.id_tahap')
            ->join('sys_role as d', 'c.id_role_tahap', 'd.id_role')
            ->where('id_permohonan', $id_permohonan);

        if(isset($id_tahap) && $id_tahap > 0)
        {
            $q->where($t.'.id_tahap', $id_tahap);
        }
        if(isset($urutan_tahap) && $urutan_tahap)
        {
            $q->where('c.urutan_tahap', $urutan_tahap);
        }

        return $q->whereNull('c.deleted_at')
            ->orderBy('created_at', 'DESC')
            ->orderBy('urutan_tahap', 'DESC')
            ->get([
                $t.'.*',
                'b.nm_user',
                'c.nm_tahap',
                'c.urutan_tahap',
                'c.ext_form_route',
                'c.id_role_tahap',
                'c.jns_tahap',
                'd.nm_role'
            ]);
    }

    public function getCurrentPerjalanan($id_permohonan)
    {
        return self::where('id_permohonan', $id_permohonan)->orderBy('created_at')->orderBy('urutan_tahap', 'DESC')->first();
    }
}
