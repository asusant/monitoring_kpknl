<?php

namespace App\Modules\MonitoringKpkNl\Controllers;

use App\Models\SysRole;
use App\Modules\Bobb\Controllers\BaseController;
use App\Modules\MonitoringKpkNl\Models\Permohonan;
use Illuminate\Http\Request;
use App\Bobb\Libs\BApp;
use Illuminate\Support\Facades\Auth;
use App\Bobb\Helpers\Helper as Help;
use App\Modules\MonitoringKpkNl\Models\Perjalanan;
use App\Modules\MonitoringKpkNl\Models\TahapMonitoring;
use App\Modules\MonitoringKpkNl\Services\SPermohonan;

class PermohonanController extends BaseController
{
    public $title = 'Data Permohonan';
    public $subtitle = 'Manajemen data Permohonan';
    public $base_route = 'permohonan';
    public $dt_order = ['deadline_tahap_aktif', 'ASC'];
    public $add_header_right = '';
    public $use_pagination = false;
    public $pagination_limit = 25;
    public $boolean_column = ['is_aktif'];
    public $boolean_key = 'aktif';

    public function __construct()
    {
        parent::__construct();
        $this->model = new Permohonan();

        $this->form = [
            'no_permohonan'  => [
                'Nomor Identitas Permohonan Penilaian',
                [
                    ['Form', 'text'],
                    ['no_permohonan', NULL, ['class' => 'form-control', 'id' => 'no_permohonan', 'placeholder' => 'IPP-0012/KNL.0802/2022']]
                ]
            ],
            'n_verifikasi' => [
                'Verifikasi Ke',
                [
                    ['Form', 'number'],
                    ['n_verifikasi', NULL, ['class' => 'form-control', 'id' => 'n_verifikasi', 'placeholder' => '1']]
                ]
            ],
            'asal_surat' => [
                'Asal Surat',
                [
                    ['Form', 'text'],
                    ['asal_surat', NULL, ['class' => 'form-control', 'id' => 'asal_surat', 'placeholder' => 'Kepala KPKNL Bekasi']]
                ]
            ],
            'no_surat' => [
                'Nomor Surat/ ND Pemohon',
                [
                    ['Form', 'text'],
                    ['no_surat', NULL, ['class' => 'form-control', 'id' => 'no_surat', 'placeholder' => 'ND-26/KNL.0802/2022']]
                ]
            ],
            'tgl_surat' => [
                'Tanggal Surat/ ND Pemohon',
                [
                    ['Form', 'text'],
                    ['tgl_surat', NULL, ['class' => 'form-control', 'id' => 'tgl_surat', 'data-datepicker' => '']]
                ]
            ],
            'pemilik_obj_penilaian' => [
                'Pemilik/ Penguasa Objek Penilaian',
                [
                    ['Form', 'text'],
                    ['pemilik_obj_penilaian', NULL, ['class' => 'form-control', 'id' => 'pemilik_obj_penilaian', 'placeholder' => 'Kementerian Keuangan']]
                ]
            ],
            'kl_eselon_1' => [
                'KL-Eselon 1',
                [
                    ['Form', 'text'],
                    ['kl_eselon_1', NULL, ['class' => 'form-control', 'id' => 'kl_eselon_1', 'placeholder' => 'Direktorat Jenderal Kekayaan Negara']]
                ]
            ],
            'satker' => [
                'Satker',
                [
                    ['Form', 'text'],
                    ['satker', NULL, ['class' => 'form-control', 'id' => 'satker', 'placeholder' => 'KPKNL Bekasi']]
                ]
            ],
            'jns_aset' => [
                'Jenis Aset',
                [
                    ['Form', 'text'],
                    ['jns_aset', NULL, ['class' => 'form-control', 'id' => 'jns_aset', 'placeholder' => 'Barang Milik Negara']]
                ]
            ],
            'dalam_rangka' => [
                'Dalam Rangka',
                [
                    ['Form', 'text'],
                    ['dalam_rangka', NULL, ['class' => 'form-control', 'id' => 'dalam_rangka', 'placeholder' => 'Penilaian BMN dalam rangka Pemindahtanganan']]
                ]
            ],
            'tindak_lanjut_bmn' => [
                'Tindak Lanjut BMN',
                [
                    ['Form', 'text'],
                    ['tindak_lanjut_bmn', NULL, ['class' => 'form-control', 'id' => 'tindak_lanjut_bmn', 'placeholder' => 'Penjualan']]
                ]
            ],
            'jns_obj_penilaian' => [
                'Jenis Objek Penilaian',
                [
                    ['Form', 'text'],
                    ['jns_obj_penilaian', NULL, ['class' => 'form-control', 'id' => 'jns_obj_penilaian', 'placeholder' => 'Selain Tanah dan Bangunan Dengan Bukti Kepemilikan']]
                ]
            ],
            'desc_obj_penilaian' => [
                'Deskripsi Objek Penilaian',
                [
                    ['Form', 'text'],
                    ['desc_obj_penilaian', NULL, ['class' => 'form-control', 'id' => 'desc_obj_penilaian', 'placeholder' => '1 unit Randis roda empat Isuzu Panther B 2051 JQ']]
                ]
            ],
            'indikasi_nilai' => [
                'Indikasi Nilai',
                [
                    ['Form', 'text'],
                    ['indikasi_nilai', NULL, ['class' => 'form-control nominal', 'id' => 'indikasi_nilai', 'placeholder' => '50,000,000']]
                ]
            ],
            'tgl_terima_ka_kantor' => [
                'Tanggal Surat/ND diterima Kepala Kantor',
                [
                    ['Form', 'text'],
                    ['tgl_terima_ka_kantor', NULL, ['class' => 'form-control', 'id' => 'tgl_terima_ka_kantor', 'data-datepicker' => '']]
                ]
            ],
            'tgl_terima_verifikator' => [
                'Tanggal Surat/ND diterima Verifikator',
                [
                    ['Form', 'text'],
                    ['tgl_terima_verifikator', NULL, ['class' => 'form-control', 'id' => 'tgl_terima_verifikator', 'data-datepicker' => '']]
                ]
            ],
            'batas_verifikasi' => [
                'Batas Waktu Verifikasi',
                [
                    ['Form', 'text'],
                    ['batas_verifikasi', NULL, ['class' => 'form-control', 'id' => 'batas_verifikasi', 'data-datepicker' => '']]
                ]
            ],
            'ket_khusus' => [
                'Keterangan Khusus',
                [
                    ['Form', 'textarea'],
                    ['ket_khusus', NULL, ['class' => 'form-control', 'id' => 'ket_khusus', 'placeholder' => '....', 'rows' => '5']]
                ]
            ],

        ];
    }

    /**
     * Index / tampil data
     */
    public function index()
    {
        // default data
        $data = $this->data;
        // tambahan data yang digunakan di view
        $data['table_columns'] = $this->table_columns;
        $data['use_validate'] = $this->use_validate;
        $data['model'] = $this->model;
        $data['help'] = $this->help;
        // main data
        $data['data'] = (new SPermohonan)->getData();
        $data['max_tahap'] = TahapMonitoring::orderBy('urutan_tahap', 'DESC')->first()->urutan_tahap;
        $data['map_role_tahap'] = (new TahapMonitoring)->getMapRoleTahap();
        return view('MonitoringKpknl::permohonan.index', $data);
    }

    /**
     * Store Data
     */
    public function store(Request $req)
    {
        $this->validate($req, $this->model->validation_data());

        $current_tahap = 1;
        $next_tahap = 2;
        $next_tahap2 = 3;
        $now = date('Y-m-d H:i:s');
        $next_deadline = (new SPermohonan)->getNextDeadline($next_tahap, $now);
        $next_deadline2 = (new SPermohonan)->getNextDeadline($next_tahap2, $now);

        $dt = $this->model;
		foreach ($dt->validation_data() as $col => $rule)
		{
            $dt->{$col} = $req->input($col);
		}
        $dt->indikasi_nilai = $this->help->fetchNominal($dt->indikasi_nilai);
        $dt->id_tahap_sebelum = $current_tahap;
        $dt->proses_tahap_sebelum = $now;
        $dt->id_user_tahap_sebelum = Auth::user()->id_user;
        $dt->id_tahap_aktif = $next_tahap;
        $dt->deadline_tahap_aktif = $next_deadline2;
		$dt->created_by = Auth::user()->id_user;
		$dt->save();

        // Insert perjalanan Sebelum
        $perjalanan = new Perjalanan;
        $perjalanan->id_permohonan = $dt->id_permohonan;
        $perjalanan->id_tahap = $current_tahap;
        $perjalanan->wkt_mulai_perjalanan = $now;
        $perjalanan->wkt_selesai_perjalanan = $now;
        $perjalanan->sts_perjalanan = 1;
        $perjalanan->id_user_perjalanan = $dt->id_user_tahap_sebelum;
        $perjalanan->catatan = "Sys: Record Otomatis";
        $perjalanan->is_deadline_manual = 0;
        $perjalanan->next_deadline = $next_deadline;
        $perjalanan->created_by = Auth::user()->id_user;
        $perjalanan->save();
        // Insert perjalanan Aktif
        $perjalanan = new Perjalanan;
        $perjalanan->id_permohonan = $dt->id_permohonan;
        $perjalanan->id_tahap = $next_tahap;
        $perjalanan->wkt_mulai_perjalanan = $now;
        $perjalanan->wkt_selesai_perjalanan = NULL;
        $perjalanan->sts_perjalanan = 0;
        $perjalanan->id_user_perjalanan = NULL;
        $perjalanan->catatan = NULL;
        $perjalanan->is_deadline_manual = 0;
        $perjalanan->next_deadline = $next_deadline2;
        $perjalanan->created_by = Auth::user()->id_user;
        $perjalanan->save();

        BApp::log('Menambah data '.$this->title.'. id='.$dt->{$dt->getPrimaryKey()}.'.', $req->except('_token'));
        return redirect(route($this->base_route.'.read', $this->route_params))->with('alert', ['success', 'Data berhasil ditambah!']);
    }

    /**
     * Update Form
     */
    public function update(Request $req)
    {
        $this->validate($req, $this->model->validation_data($req->input($this->model->getPrimaryKey())));

        $dt = $this->model->findOrFail($req->input($this->model->getPrimaryKey()));
		foreach ($dt->validation_data($req->input($this->model->getPrimaryKey())) as $col => $rule)
		{
			if($req->input($col) != '')
            {
                $dt->{$col} = $req->input($col);
            }
		}
        $dt->indikasi_nilai = $this->help->fetchNominal($dt->indikasi_nilai);
        $dt->updated_by = Auth::user()->id_user;

        BApp::log('Mengubah data '.$this->title.'. id='.$dt->{$this->model->getPrimaryKey()}.'.', $dt->getOriginal(), $req->except('_token'));
        $dt->save();
        return redirect(route($this->base_route.'.read', $this->route_params))->with('alert', ['success', 'Data berhasil diubah!']);
    }
}
