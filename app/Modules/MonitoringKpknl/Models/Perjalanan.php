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
        '1' => 'Diterima',
        '2' => 'Penghapusan',
        '3' => 'Kerja Sama Pemanfaatan (KSP)'
    ];
    public $class_sts_perjalanan = [
        'sewa'          => 'Sewa',
        'penjualan'     => 'Penjualan',
        'penghapusan'   => 'Penghapusan',
        'ksp'           => 'Kerja Sama Pemanfaatan (KSP)',
        'bgs'           => 'Bangun Guna Serah (BGS)',
        'bsg'           => 'Bangun Serah Guna (BSG)'
    ];

    public static function validation_data($update_id = "NULL") {
        return [];
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getPerjalanan($id_permohonan)
    {
        $t = $this->table;
        return self::leftJoin('sys_user as b', 'id_user_perjalanan', 'b.id_user')
            ->join('tahap_monitoring as c', $t.'.id_tahap', 'c.id_tahap')
            ->join('sys_role as d', 'c.id_role_tahap', 'd.id_role')
            ->where('id_permohonan', $id_permohonan)
            ->whereNull('c.deleted_at')
            ->orderBy('created_at', 'DESC')
            ->orderBy('urutan_tahap', 'DESC')
            ->get([
                $t.'.*',
                'b.nm_user',
                'c.nm_tahap',
                'c.urutan_tahap',
                'c.ext_form_route',
                'c.id_role_tahap',
                'd.nm_role'
            ]);
    }

    public function simpanPerjalanan($permohonan, $sts_perjalanan, $catatan, $is_deadline_manual, $now = '')
    {
        if($now == '')
        {
            $now = date('Y-m-d H:i:s');
        }
        $perjalanan = new Perjalanan;
        $perjalanan->id_permohonan = $permohonan->id_permohonan;
        $perjalanan->id_tahap = $permohonan->id_tahap_sebelum;
        $perjalanan->wkt_mulai_perjalanan = $now;
        $perjalanan->wkt_selesai_perjalanan = $now;
        $perjalanan->sts_perjalanan = $sts_perjalanan;
        $perjalanan->id_user_perjalanan = $permohonan->id_user_tahap_sebelum;
        $perjalanan->catatan = $catatan;
        $perjalanan->is_deadline_manual = $is_deadline_manual;
        $perjalanan->next_deadline = $permohonan->deadline_tahap_aktif;
        $perjalanan->created_by = Auth::user()->id_user;
        $perjalanan->save();
    }
}
