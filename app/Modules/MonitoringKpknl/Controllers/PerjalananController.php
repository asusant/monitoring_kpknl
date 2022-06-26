<?php

namespace App\Modules\MonitoringKpkNl\Controllers;

use App\Modules\MonitoringKpkNl\Models\Permohonan;
use App\Bobb\Helpers\Helper as Help;
use App\Modules\MonitoringKpkNl\Models\Perjalanan;
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
            'help'          => (new Help)
        ];
    }

    public function index()
    {
        $data = $this->data;
        return view('MonitoringKpknl::perjalanan.index', $data);
    }

    public function detail(Request $req)
    {
        $no_permohonan = $req->input('no_permohonan');
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

    public function formVerifikasi($id)
    {
        $data = $this->data;
        $data['permohonan'] = Permohonan::find($id)->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }
        return view('MonitoringKpknl::perjalanan.detail', $data);
    }

}
