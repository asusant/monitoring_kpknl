<?php

namespace App\Modules\MonitoringKpkNl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermohonanExt extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'permohonan_ext';
    protected $primaryKey = 'id_permohonan';
    protected $fillable = ['dok_id_obj', 'dok_jns_nilai', 'dok_latar_belakang', 'dok_tujuan', 'dok_legalitas', 'dok_desc_obj', 'dok_tata_usaha', 'dok_sk_berat_volume', 'dok_laporan_penilai', 'dok_fc_ba_penyitaan', 'dok_proposal', 'dok_laporan_keuangan', 'dok_laporan_apip', 'dok_lainnya', 'id_ketua_tim', 'no_nd_tim_penilai', 'tgl_nd_tim_penilai', 'hal_nd_tim_penilai', 'no_sk_tim_penilai', 'tgl_sk_tim_penilai', 'hal_sk_tim_penilai', 'dok_permohonan_lain', 'dok_sk_tim_penilaian', 'dok_permohonan_penilaian', 'is_nd_survey_jadi', 'is_nd_st_penilai_jadi', 'no_nd_survey_tim_penilai', 'tgl_nd_survey_tim_penilai', 'hal_nd_survey_tim_penilai', 'no_nd_st_tim_penilai', 'tgl_nd_st_tim_penilai', 'hal_nd_st_tim_penilai', 'jadwal_survey', 'no_st_tim_penilai', 'tgl_st_tim_penilai', 'hal_st_tim_penilai', 'created_by', 'updated_by', 'deleted_by'
    ];
    public $cols = [];

    public function __construct()
    {
        parent::__construct();
        $this->cols = $this->fillable;
    }

    public $ref_boolean_col = [
        'dok_id_obj'            => 'Identitas Objek Penilaian',
        'dok_jns_nilai'         => 'Jenis Nilai yang dimohonkan',
        'dok_latar_belakang'    => 'Latar Belakang Permohonan',
        'dok_tujuan'            => 'Tujuan Penilaian',
        'dok_legalitas'         => 'Dokumen Legalitas',
        'dok_desc_obj'          => 'Deskripsi Objek Penilaian',
        'dok_tata_usaha'        => 'Dokumen Penatausahaan Barang / Surat Keterangan NJOP / Perkiraan indikasi nilai',
        'dok_sk_berat_volume'   => 'Surat Keterangan Berat atau Volume (Jika objek penilaian berupa limbah padat (scrap) / limbah cair)',
        'dok_laporan_penilai'   => 'Laporan Penilaian sebelumnya (Jika permohonan penilaian ulang)',
        'dok_fc_ba_penyitaan'   => 'Fotokopi Berita Acara Penyitaan, untuk objek Penilaian berupa Benda Sitaan',
        'dok_proposal'          => 'Proposal KSP / BGS / BSG',
        'dok_laporan_keuangan'  => 'Laporan Keuangan audited (Jika permohonan adalah KSP / BGS / BSG terlanjur)',
        'dok_laporan_apip'      => 'Laporan dari APIP',
    ];

    public $ref_jns_form_khusus = ['ksp', 'bgs', 'bsg'];

    public static function validation_data($update_id = "NULL") {
        return [
            'dok_id_obj'            => 'required|in:0,1',
            'dok_jns_nilai'         => 'required|in:0,1',
            'dok_latar_belakang'    => 'required|in:0,1',
            'dok_tujuan'            => 'required|in:0,1',
            'dok_legalitas'         => 'required|in:0,1',
            'dok_desc_obj'          => 'required|in:0,1',
            'dok_tata_usaha'        => 'required|in:0,1',
            'dok_sk_berat_volume'   => 'required|in:0,1',
            'dok_laporan_penilai'   => 'required|in:0,1',
            'dok_fc_ba_penyitaan'   => 'required|in:0,1',
            'dok_proposal'          => 'required|in:0,1',
            'dok_laporan_keuangan'  => 'required|in:0,1',
            'dok_laporan_apip'      => 'required|in:0,1',
            'dok_lainnya'           => 'required|string|max:192'
        ];
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }
}
