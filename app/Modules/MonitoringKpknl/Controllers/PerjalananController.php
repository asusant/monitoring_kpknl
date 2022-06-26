<?php

namespace App\Modules\MonitoringKpkNl\Controllers;

use App\Modules\MonitoringKpkNl\Models\Permohonan;
use App\Bobb\Helpers\Helper as Help;
use App\Modules\MonitoringKpkNl\Models\Perjalanan;
use App\Modules\MonitoringKpkNl\Models\PermohonanExt;
use App\Modules\MonitoringKpkNl\Models\TahapMonitoring;
use App\Modules\MonitoringKpkNl\Services\SPermohonan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerjalananController
{
    public $title = 'Perjalanan Permohonan';
    public $subtitle = 'Manajemen Perjalanan Permohonan';
    public $base_route = 'perjalanan_permohonan';
    public $breadcrumbs = [];
    public $data = [];

    public function __construct()
    {
        $this->breadcrumbs = [
            'Dashboard' => route('dashboard.read')
        ];
        $this->data = [
            'title'         => $this->title,
            'subtitle'      => $this->subtitle,
            'base_route'    => $this->base_route,
            'breadcrumbs'   => $this->breadcrumbs,
            'help'          => (new Help),
            'now'           => date('Y-m-d H:i:s')
        ];
    }

    public function index()
    {
        $data = $this->data;
        return view('MonitoringKpknl::perjalanan.index', $data);
    }

    public function detail($no_permohonan = '', Request $req)
    {
        if($no_permohonan != '')
        {
            $no_permohonan = base64_decode($no_permohonan);
        }
        else
        {
            $no_permohonan = $req->input('no_permohonan');
        }

        if(!$no_permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Isian Nomor Permohonan tidak boleh kosong!']);
        }
        $data = $this->data;
        $data['permohonan'] = (new Permohonan)->getDetail(['no_permohonan'=>$no_permohonan])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Permohonan dengan nomor <strong>'.$no_permohonan.'</strong> tidak ditemukan!']);
        }
        session()->put('filter-no-permohonan', $no_permohonan);
        $data['perjalanan'] = (new Perjalanan())->getPerjalanan($data['permohonan']->id_permohonan);
        $data['now'] = date('Y-m-d H:i:s');

        return view('MonitoringKpknl::perjalanan.detail', $data);
    }

    public function formVerifikasiKelengkapan($id)
    {
        $data = $this->data;
        $data['title'] = 'Form Verifikasi Kelengkapan Berkas';
        $data['subtitle'] = 'Lengkapi Form Verifikasi Kelengkapan Berkas';
        $data['permohonan'] = (new Permohonan)->getDetail(['id_permohonan' => $id])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }
        $data['next_tahap'] = (new TahapMonitoring)->getNextTahap($data['permohonan']->id_tahap_aktif);
        $data['next_deadline'] = (new SPermohonan)->getNextDeadline($data['next_tahap']->urutan_tahap, $data['now']);
        $data['permohonan_ext'] = PermohonanExt::find($id);
        $data['allow_save'] = true;
        if($data['permohonan_ext'])
        {
            $data['allow_save'] = false;
        }
        $data['list_verifikasi_boolean'] = (new PermohonanExt())->ref_boolean_col;
        $data['ref_permohonan_ext'] = (new PermohonanExt());
        $data['ref_sts_permohonan'] = $data['permohonan']->ref_sts_permohonan;
        if($data['allow_save'])
        {
            unset($data['ref_sts_permohonan']['0']);
            unset($data['ref_sts_permohonan']['9']);
        }
        return view('MonitoringKpknl::perjalanan.verifikasi-berkas', $data);
    }

    public function postVerifikasiKelengkapan(Request $req)
    {
        $rules = PermohonanExt::validation_data();
        $rules['sts_permohonan'] = 'required|in:1,2,3,4';
        $rules['catatan'] = 'required|string|max:192';
        $rules['is_deadline_manual'] = '';
        $this->validate($req, $rules);
    }

}
