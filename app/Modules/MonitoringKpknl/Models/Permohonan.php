<?php

namespace App\Modules\MonitoringKpkNl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permohonan extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'permohonan';
    protected $primaryKey = 'id_permohonan';
    protected $fillable = ['no_permohonan', 'n_verifikasi', 'asal_surat', 'no_surat', 'tgl_surat', 'kl_eselon_1', 'satker', 'jns_aset', 'dalam_rangka', 'tindak_lanjut_bmn', 'pemilik_obj_penilaian', 'jns_obj_penilaian', 'desc_obj_penilaian', 'indikasi_nilai', 'tgl_terima_ka_kantor', 'tgl_terima_verifikator', 'batas_verifikasi', 'ket_khusus', 'id_tahap_aktif', 'deadline_tahap_aktif', 'id_tahap_sebelum', 'proses_tahap_sebelum', 'id_user_tahap_sebelum', 'sts_permohonan', 'created_by', 'updated_by', 'deleted_by'];

    public $ref_jns_permohonan = [
        'sewa'          => 'Sewa',
        'penjualan'     => 'Penjualan',
        'penghapusan'   => 'Penghapusan',
        'ksp'           => 'Kerja Sama Pemanfaatan (KSP)',
        'bgs'           => 'Bangun Guna Serah (BGS)',
        'bsg'           => 'Bangun Serah Guna (BSG)'
    ];

    public $ref_sts_permohonan = [
        '0' => 'Antrian Verifikasi',
        '1' => 'Proses',
        '2' => 'Dikembalikan',
        '3' => 'Hold',
        '4' => 'Tolak',
        '9' => 'Selesai'
    ];
    public $class_sts_permohonan = [
        '0' => 'primary',
        '1' => 'info',
        '2' => 'warning',
        '3' => 'warning',
        '4' => 'danger',
        '9' => 'success'
    ];

    public static function validation_data($update_id = "NULL") {
        return [
            'no_permohonan'         => 'required|string|max:50|unique:permohonan,no_permohonan,'.$update_id.',id_permohonan,deleted_at,NULL',
            'n_verifikasi'          => 'required|numeric|min:1',
            'asal_surat'            => 'required|string|max:192',
            'no_surat'              => 'required|string|max:50',
            'tgl_surat'             => 'required|date',
            'kl_eselon_1'           => 'required|string|max:192',
            'satker'                => 'required|string|max:192',
            'jns_aset'              => 'required|string|max:192',
            'dalam_rangka'          => 'required|string|max:192',
            'tindak_lanjut_bmn'     => 'required|string|max:192',
            'pemilik_obj_penilaian' => 'required|string|max:192',
            'jns_obj_penilaian'     => 'required|string|max:192',
            'desc_obj_penilaian'    => 'required|string',
            'indikasi_nilai'        => 'required',
            'tgl_terima_ka_kantor'  => 'required|date',
            'tgl_terima_verifikator'=> 'required|date',
            'batas_verifikasi'      => 'required|date',
            'ket_khusus'            => 'nullable|string'
        ];
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getDetail($filters = [])
    {
        extract($filters);
        $t = $this->table;
        $q = self::join('tahap_monitoring as b', $t.'.id_tahap_sebelum', 'b.id_tahap')
            ->leftJoin('tahap_monitoring as c', $t.'.id_tahap_aktif', 'c.id_tahap')
            ->join('sys_role as d', 'b.id_role_tahap', 'd.id_role')
            ->leftJoin('sys_role as e', 'c.id_role_tahap', 'e.id_role')
            ->select(
                $t.'.*',
                'b.nm_tahap as nm_tahap_sebelum',
                'b.urutan_tahap as urutan_tahap_sebelum',
                'd.nm_role as nm_role_sebelum',
                'c.nm_tahap as nm_tahap_aktif',
                'c.urutan_tahap as urutan_tahap_aktif',
                'e.nm_role as nm_role_aktif'
            )
            ;
        if(isset($no_permohonan))
        {
            $q->where('no_permohonan', $no_permohonan);
        }
        return $q->get();
    }
}