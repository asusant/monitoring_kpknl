<?php

namespace App\Modules\MonitoringKpkNl\Controllers;

use App\Modules\MonitoringKpkNl\Models\Permohonan;
use App\Bobb\Helpers\Helper as Help;
use App\Bobb\Libs\BApp;
use App\Modules\MonitoringKpkNl\Models\Perjalanan;
use App\Modules\MonitoringKpkNl\Models\PermohonanExt;
use App\Modules\MonitoringKpkNl\Models\TahapMonitoring;
use App\Modules\MonitoringKpkNl\Services\SPermohonan;
use App\Http\Controllers\Controller;
use App\Modules\MonitoringKpkNl\Models\TimPenilaian;
use App\Modules\MonitoringKpkNl\Models\TimPenilaiPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PerjalananController extends Controller
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

    public function detail(Request $req, $no_permohonan = '')
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
        if($data['permohonan_ext'] && $data['permohonan']->id_tahap_aktif > 2)
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
        $rules['catatan'] = 'required_unless:sts_permohonan,1|max:192';
        $rules['is_deadline_manual'] = 'required|in:0,1';
        $rules['tgl_deadline'] = 'required_if:is_deadline_manual,1';
        $rules['jam_deadline'] = 'required_if:is_deadline_manual,1';
        $this->validate($req, $rules);

        $permohonan = (new Permohonan)->getDetail(['id_permohonan' => $req->input('id_permohonan')])->first();
        if(!$permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $sts_lanjut = $req->input('sts_permohonan');
        if($sts_lanjut > 2)
        {
            $sts_lanjut = 2;
        }

        $now = date('Y-m-d H:i:s');
        $sPermohonan = (new SPermohonan);
        $dt_process = [
            'sts_lanjut'            => $sts_lanjut,
            'wkt_process'           => $now,
            'catatan'               => $req->input('catatan'),
            'is_deadline_manual'    => $req->input('is_deadline_manual'),
            'jam_deadline'          => $req->input('jam_deadline'),
            'tgl_deadline'          => $req->input('tgl_deadline')
        ];

        switch ($req->input('sts_permohonan')) {
            case '1':
                $sPermohonan->prosesPerjalanan($permohonan, $dt_process);
                break;
            case '2':
                $sPermohonan->prosesPerjalanan($permohonan, $dt_process, 1);
                break;
            case '3':
                $sPermohonan->prosesPerjalanan($permohonan, $dt_process, 2);
                break;
            case '4':
                $sPermohonan->prosesPerjalanan($permohonan, $dt_process, 0);
                break;
            default:
                return redirect()->back()->withInput()->with('alert', ['danger', 'Isian status permohonan tidak valid!']);
                break;
        }

        $permohonan->sts_permohonan = $req->input('sts_permohonan');
        $permohonan->save();

        $permohonan_ext = PermohonanExt::find($permohonan->id_permohonan);
        if(!$permohonan_ext)
        {
            $permohonan_ext = new PermohonanExt();
            $permohonan_ext->created_by = Auth::user()->id_user;
        }
        else
        {
            $permohonan_ext->updated_by = Auth::user()->id_user;
        }
        // simpan permohonan_ext
        $permohonan_ext->id_permohonan = $permohonan->id_permohonan;
        foreach (PermohonanExt::validation_data() as $col => $desc)
        {
            $permohonan_ext->{$col} = $req->input($col);
        }
        $permohonan_ext->save();

        BApp::log('Menyimpan verifikasi kelengkapan berkas.', $req->except('_token'));

        return redirect(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]))->with('alert', ['success', 'Berhasil memproses data permohonan <strong>'.$permohonan->no_permohonan.'</strong>']);
    }

    public function formKecukupanPenilai($id)
    {
        $data = $this->data;
        $data['title'] = 'Form Kecukupan Penilai';
        $data['subtitle'] = 'Lengkapi Form Kecukupan Penilai Berikut';
        $data['permohonan'] = (new Permohonan)->getDetail(['id_permohonan' => $id])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $data['next_tahap'] = (new TahapMonitoring)->getNextTahap($data['permohonan']->id_tahap_aktif);
        $data['next_deadline'] = (new SPermohonan)->getNextDeadline($data['next_tahap']->urutan_tahap, $data['now']);
        $data['ref_penilai'] = (new TimPenilaian)->getForSelect(true);

        $penilai = (new TimPenilaiPermohonan)->getPenilai(['id_permohonan' => $data['permohonan']->id_permohonan]);
        $data['penilai'] = [
            'ketua_tim'     => NULL,
        ];

        foreach ($penilai as $r)
        {
            if($r->is_ketua == 1)
            {
                $data['penilai']['ketua_tim'] = $r->id_tim_penilai;
            }
            else
            {
                $data['penilai']['anggota_tim[]'][] = $r->id_tim_penilai;
            }
        }

        $data['allow_save'] = false;
        if(Route::currentRouteName() == $data['permohonan']->ext_form_route)
        {
            $data['allow_save'] = true;
        }
        // dd($data['allow_save'], Route::currentRouteName(), $data['permohonan']->ext_form_route);
        $data['ref_sts_permohonan'] = (new Perjalanan)->ref_sts_perjalanan;

        return view('MonitoringKpknl::perjalanan.kecukupan-penilai', $data);
    }

    public function postKecukupanPenilai(Request $req)
    {
        $perjalanan = new Perjalanan();

        $rules = $perjalanan->validation_data();
        $rules['ketua_tim']     = 'required_if:sts_permohonan,1';
        $rules['anggota_tim']   = 'nullable|array';
        $rules['anggota_tim.*'] = 'numeric';
        $this->validate($req, $rules);

        $penilai = [];
        if($req->input('ketua_tim'))
        {
            $penilai = [
                $req->input('ketua_tim')    => $req->input('ketua_tim')
            ];
        }

        // tim_penilai
        if($req->has('anggota_tim'))
        {
            foreach ($req->input('anggota_tim') as $v)
            {
                if(!isset($penilai[$v]))
                    $penilai[$v] = $v;
            }
        }

        if($req->input('sts_permohonan') == 1)
        {
            if(sizeof($penilai) % 2 == 0)
            {
                return redirect()->back()->withInput()->with('alert', ['danger', 'Tim Penilai Harus Ganjil!']);
            }
        }

        $permohonan = (new Permohonan)->getDetail(['id_permohonan' => $req->input('id_permohonan')])->first();
        if(!$permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }
        $permohonan_ext = PermohonanExt::find($permohonan->id_permohonan);

        if(sizeof($penilai) > 0)
        {
            foreach ($penilai as $v)
            {
                $np = new TimPenilaiPermohonan();
                $np->id_permohonan = $req->input('id_permohonan');
                $np->id_tim_penilai = $v;
                $np->is_ketua = 0;
                if($req->input('ketua_tim') == $v)
                {
                    $np->is_ketua = 1;
                }
                $np->created_by = Auth::user()->id_user;
                $np->save();
            }
        }

        $now = date('Y-m-d H:i:s');
        $sPermohonan = (new SPermohonan);
        $dt_process = [
            'sts_lanjut'            => $req->input('sts_permohonan'),
            'wkt_process'           => $now,
            'catatan'               => $req->input('catatan'),
            'is_deadline_manual'    => $req->input('is_deadline_manual'),
            'jam_deadline'          => $req->input('jam_deadline'),
            'tgl_deadline'          => $req->input('tgl_deadline')
        ];

        $sPermohonan->prosesPerjalanan($permohonan, $dt_process);

        if($req->input('ketua_tim'))
        {
            $permohonan_ext->id_ketua_tim = $req->input('ketua_tim');
            $permohonan_ext->updated_by = Auth::user()->id_user;
            $permohonan_ext->save();
        }

        BApp::log('Menyimpan data verifikasi kecukupan penilai.', $req->except('_token'));

        return redirect(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]))->with('alert', ['success', 'Berhasil memproses data permohonan <strong>'.$permohonan->no_permohonan.'</strong>']);
    }

    public function formKonfirmasi($id)
    {
        $data = $this->data;
        $data['permohonan'] = (new Permohonan)->getDetail(['id_permohonan' => $id])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $data['title'] = 'Form '.$data['permohonan']->nm_tahap_aktif;
        $data['subtitle'] = 'Lengkapi Form '.$data['permohonan']->nm_tahap_aktif.' Berikut';

        $data['next_tahap'] = (new TahapMonitoring)->getNextTahap($data['permohonan']->id_tahap_aktif);
        $data['next_deadline'] = $data['now'];
        if($data['next_tahap'])
        {
            $data['next_deadline'] = (new SPermohonan)->getNextDeadline($data['next_tahap']->urutan_tahap, $data['now']);
        }

        $data['allow_save'] = true;
        $data['ref_sts_permohonan'] = (new Perjalanan)->ref_sts_perjalanan;

        return view('MonitoringKpknl::perjalanan.konfirmasi', $data);
    }

    public function postKonfirmasi(Request $req)
    {
        $perjalanan = new Perjalanan();

        $rules = $perjalanan->validation_data();
        $this->validate($req, $rules);

        $permohonan = (new Permohonan)->getDetail(['id_permohonan' => $req->input('id_permohonan')])->first();
        if(!$permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $now = date('Y-m-d H:i:s');
        $sPermohonan = (new SPermohonan);
        $dt_process = [
            'sts_lanjut'            => $req->input('sts_permohonan'),
            'wkt_process'           => $now,
            'catatan'               => $req->input('catatan'),
            'is_deadline_manual'    => $req->input('is_deadline_manual'),
            'jam_deadline'          => $req->input('jam_deadline'),
            'tgl_deadline'          => $req->input('tgl_deadline')
        ];

        $sPermohonan->prosesPerjalanan($permohonan, $dt_process);

        BApp::log('Melakukan Konfirmasi Proses '.$permohonan->nm_tahap_aktif.'.', $req->except('_token'));

        return redirect(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]))->with('alert', ['success', 'Berhasil memproses data permohonan <strong>'.$permohonan->no_permohonan.'</strong>']);
    }

    public function formNdSkTimPenilai($id)
    {
        $data = $this->data;
        $data['permohonan'] = (new Permohonan)->getDetail(['id_permohonan' => $id])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }
        $data['permohonan_ext'] = PermohonanExt::find($id);

        $data['title'] = 'Form '.$data['permohonan']->nm_tahap_aktif;
        $data['subtitle'] = 'Lengkapi Form '.$data['permohonan']->nm_tahap_aktif.' Berikut';

        $data['next_tahap'] = (new TahapMonitoring)->getNextTahap($data['permohonan']->id_tahap_aktif);
        $data['next_deadline'] = $data['now'];
        if($data['next_tahap'])
        {
            $data['next_deadline'] = (new SPermohonan)->getNextDeadline($data['next_tahap']->urutan_tahap, $data['now']);
        }

        $data['allow_save'] = true;
        $data['ref_sts_permohonan'] = (new Perjalanan)->ref_sts_perjalanan;

        return view('MonitoringKpknl::perjalanan.nd-sk-tim-penilai', $data);
    }

    public function postNdSkTimPenilai(Request $req)
    {
        $perjalanan = new Perjalanan();

        $rules = $perjalanan->validation_data();
        $rules['no_nd_tim_penilai'] = 'required|string';
        $rules['tgl_nd_tim_penilai'] = 'required|date';
        $rules['hal_nd_tim_penilai'] = 'required|string';
        $this->validate($req, $rules);

        $permohonan = (new Permohonan)->getDetail(['id_permohonan' => $req->input('id_permohonan')])->first();
        if(!$permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $now = date('Y-m-d H:i:s');
        $sPermohonan = (new SPermohonan);
        $dt_process = [
            'sts_lanjut'            => $req->input('sts_permohonan'),
            'wkt_process'           => $now,
            'catatan'               => $req->input('catatan'),
            'is_deadline_manual'    => $req->input('is_deadline_manual'),
            'jam_deadline'          => $req->input('jam_deadline'),
            'tgl_deadline'          => $req->input('tgl_deadline')
        ];

        $sPermohonan->prosesPerjalanan($permohonan, $dt_process);

        $permohonan_ext = PermohonanExt::find($req->input('id_permohonan'));
        $permohonan_ext->no_nd_tim_penilai = $req->input('no_nd_tim_penilai');
        $permohonan_ext->tgl_nd_tim_penilai = $req->input('tgl_nd_tim_penilai');
        $permohonan_ext->hal_nd_tim_penilai = $req->input('hal_nd_tim_penilai');
        $permohonan_ext->updated_by = Auth::user()->id;
        $permohonan_ext->save();

        BApp::log('Melakukan Konfirmasi Proses '.$permohonan->nm_tahap_aktif.'.', $req->except('_token'));

        return redirect(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]))->with('alert', ['success', 'Berhasil memproses data permohonan <strong>'.$permohonan->no_permohonan.'</strong>']);
    }

    public function formSkTimPenilai($id)
    {
        $data = $this->data;
        $data['permohonan'] = (new Permohonan)->getDetail(['id_permohonan' => $id])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }
        $data['permohonan_ext'] = PermohonanExt::find($id);

        $data['title'] = 'Form '.$data['permohonan']->nm_tahap_aktif;
        $data['subtitle'] = 'Lengkapi Form '.$data['permohonan']->nm_tahap_aktif.' Berikut';

        $data['next_tahap'] = (new TahapMonitoring)->getNextTahap($data['permohonan']->id_tahap_aktif);
        $data['next_deadline'] = $data['now'];
        if($data['next_tahap'])
        {
            $data['next_deadline'] = (new SPermohonan)->getNextDeadline($data['next_tahap']->urutan_tahap, $data['now']);
        }

        $data['allow_save'] = true;
        $data['ref_sts_permohonan'] = (new Perjalanan)->ref_sts_perjalanan;

        return view('MonitoringKpknl::perjalanan.sk-tim-penilai', $data);
    }

    public function postSkTimPenilai(Request $req)
    {
        $perjalanan = new Perjalanan();

        $rules = $perjalanan->validation_data();
        $rules['no_sk_tim_penilai'] = 'required|string';
        $rules['tgl_sk_tim_penilai'] = 'required|date';
        $rules['hal_sk_tim_penilai'] = 'required|string';
        $this->validate($req, $rules);

        $permohonan = (new Permohonan)->getDetail(['id_permohonan' => $req->input('id_permohonan')])->first();
        if(!$permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $now = date('Y-m-d H:i:s');
        $sPermohonan = (new SPermohonan);
        $dt_process = [
            'sts_lanjut'            => $req->input('sts_permohonan'),
            'wkt_process'           => $now,
            'catatan'               => $req->input('catatan'),
            'is_deadline_manual'    => $req->input('is_deadline_manual'),
            'jam_deadline'          => $req->input('jam_deadline'),
            'tgl_deadline'          => $req->input('tgl_deadline')
        ];

        $sPermohonan->prosesPerjalanan($permohonan, $dt_process);

        $permohonan_ext = PermohonanExt::find($req->input('id_permohonan'));
        $permohonan_ext->no_sk_tim_penilai = $req->input('no_sk_tim_penilai');
        $permohonan_ext->tgl_sk_tim_penilai = $req->input('tgl_sk_tim_penilai');
        $permohonan_ext->hal_sk_tim_penilai = $req->input('hal_sk_tim_penilai');
        $permohonan_ext->updated_by = Auth::user()->id;
        $permohonan_ext->save();

        BApp::log('Melakukan Konfirmasi Proses '.$permohonan->nm_tahap_aktif.'.', $req->except('_token'));

        return redirect(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]))->with('alert', ['success', 'Berhasil memproses data permohonan <strong>'.$permohonan->no_permohonan.'</strong>']);
    }

    public function formSerahTerimaTimPenilai($id)
    {
        $data = $this->data;
        $data['permohonan'] = (new Permohonan)->getDetail(['id_permohonan' => $id])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }
        $data['permohonan_ext'] = PermohonanExt::find($id);

        $data['title'] = 'Form '.$data['permohonan']->nm_tahap_aktif;
        $data['subtitle'] = 'Lengkapi Form '.$data['permohonan']->nm_tahap_aktif.' Berikut';

        $data['next_tahap'] = (new TahapMonitoring)->getNextTahap($data['permohonan']->id_tahap_aktif);
        $data['next_deadline'] = $data['now'];
        if($data['next_tahap'])
        {
            $data['next_deadline'] = (new SPermohonan)->getNextDeadline($data['next_tahap']->urutan_tahap, $data['now']);
        }

        $data['allow_save'] = true;
        $data['ref_sts_permohonan'] = (new Perjalanan)->ref_sts_perjalanan;

        return view('MonitoringKpknl::perjalanan.st-tim-penilai', $data);
    }

    public function postSerahTerimaTimPenilai(Request $req)
    {
        $perjalanan = new Perjalanan();

        $rules = $perjalanan->validation_data();
        $rules['dok_permohonan_penilaian'] = 'required|in:0,1';
        $rules['dok_sk_tim_penilaian'] = 'required|in:0,1';
        $rules['dok_permohonan_lain'] = 'nullable|string';
        $this->validate($req, $rules);

        $permohonan = (new Permohonan)->getDetail(['id_permohonan' => $req->input('id_permohonan')])->first();
        if(!$permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $now = date('Y-m-d H:i:s');
        $sPermohonan = (new SPermohonan);
        $dt_process = [
            'sts_lanjut'            => $req->input('sts_permohonan'),
            'wkt_process'           => $now,
            'catatan'               => $req->input('catatan'),
            'is_deadline_manual'    => $req->input('is_deadline_manual'),
            'jam_deadline'          => $req->input('jam_deadline'),
            'tgl_deadline'          => $req->input('tgl_deadline')
        ];

        $sPermohonan->prosesPerjalanan($permohonan, $dt_process);

        $permohonan_ext = PermohonanExt::find($req->input('id_permohonan'));
        $permohonan_ext->dok_permohonan_penilaian = $req->input('dok_permohonan_penilaian');
        $permohonan_ext->dok_sk_tim_penilaian = $req->input('dok_sk_tim_penilaian');
        $permohonan_ext->dok_permohonan_lain = $req->input('dok_permohonan_lain');
        $permohonan_ext->updated_by = Auth::user()->id;
        $permohonan_ext->save();

        BApp::log('Melakukan Konfirmasi Proses '.$permohonan->nm_tahap_aktif.'.', $req->except('_token'));

        return redirect(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]))->with('alert', ['success', 'Berhasil memproses data permohonan <strong>'.$permohonan->no_permohonan.'</strong>']);
    }

    public function formKonsepNd($id)
    {
        $data = $this->data;
        $data['permohonan'] = (new Permohonan)->getDetail(['id_permohonan' => $id])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }
        $data['permohonan_ext'] = PermohonanExt::find($id);

        $data['title'] = 'Form '.$data['permohonan']->nm_tahap_aktif;
        $data['subtitle'] = 'Lengkapi Form '.$data['permohonan']->nm_tahap_aktif.' Berikut';

        $data['next_tahap'] = (new TahapMonitoring)->getNextTahap($data['permohonan']->id_tahap_aktif);
        $data['next_deadline'] = $data['now'];
        if($data['next_tahap'])
        {
            $data['next_deadline'] = (new SPermohonan)->getNextDeadline($data['next_tahap']->urutan_tahap, $data['now']);
        }

        $data['allow_save'] = true;
        $data['ref_sts_permohonan'] = (new Perjalanan)->ref_sts_perjalanan;

        return view('MonitoringKpknl::perjalanan.konsep-nd', $data);
    }

    public function postKonsepNd(Request $req)
    {
        $perjalanan = new Perjalanan();

        $rules = $perjalanan->validation_data();
        $rules['is_nd_st_penilai_jadi'] = 'required|in:0,1';
        $rules['is_nd_survey_jadi'] = 'required|in:0,1';
        $this->validate($req, $rules);

        $permohonan = (new Permohonan)->getDetail(['id_permohonan' => $req->input('id_permohonan')])->first();
        if(!$permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $now = date('Y-m-d H:i:s');
        $sPermohonan = (new SPermohonan);
        $dt_process = [
            'sts_lanjut'            => $req->input('sts_permohonan'),
            'wkt_process'           => $now,
            'catatan'               => $req->input('catatan'),
            'is_deadline_manual'    => $req->input('is_deadline_manual'),
            'jam_deadline'          => $req->input('jam_deadline'),
            'tgl_deadline'          => $req->input('tgl_deadline')
        ];

        $sPermohonan->prosesPerjalanan($permohonan, $dt_process);

        $permohonan_ext = PermohonanExt::find($req->input('id_permohonan'));
        $permohonan_ext->is_nd_st_penilai_jadi = $req->input('is_nd_st_penilai_jadi');
        $permohonan_ext->is_nd_survey_jadi = $req->input('is_nd_survey_jadi');
        $permohonan_ext->updated_by = Auth::user()->id;
        $permohonan_ext->save();

        BApp::log('Melakukan Konfirmasi Proses '.$permohonan->nm_tahap_aktif.'.', $req->except('_token'));

        return redirect(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]))->with('alert', ['success', 'Berhasil memproses data permohonan <strong>'.$permohonan->no_permohonan.'</strong>']);
    }

    public function formTtdNdStPenilai($id)
    {
        $data = $this->data;
        $data['permohonan'] = (new Permohonan)->getDetail(['id_permohonan' => $id])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }
        $data['permohonan_ext'] = PermohonanExt::find($id);

        $data['title'] = 'Form '.$data['permohonan']->nm_tahap_aktif;
        $data['subtitle'] = 'Lengkapi Form '.$data['permohonan']->nm_tahap_aktif.' Berikut';

        $data['next_tahap'] = (new TahapMonitoring)->getNextTahap($data['permohonan']->id_tahap_aktif);
        $data['next_deadline'] = $data['now'];
        if($data['next_tahap'])
        {
            $data['next_deadline'] = (new SPermohonan)->getNextDeadline($data['next_tahap']->urutan_tahap, $data['now']);
        }

        $data['allow_save'] = true;
        $data['ref_sts_permohonan'] = (new Perjalanan)->ref_sts_perjalanan;

        return view('MonitoringKpknl::perjalanan.nd-st-penilai', $data);
    }

    public function postTtdNdStPenilai(Request $req)
    {
        $perjalanan = new Perjalanan();

        $rules = $perjalanan->validation_data();
        $rules['no_nd_st_tim_penilai'] = 'required|string';
        $rules['tgl_nd_st_tim_penilai'] = 'required|date';
        $rules['hal_nd_st_tim_penilai'] = 'required|string';

        $rules['no_nd_survey_tim_penilai'] = 'required|string';
        $rules['tgl_nd_survey_tim_penilai'] = 'required|date';
        $rules['hal_nd_survey_tim_penilai'] = 'required|string';
        $this->validate($req, $rules);

        $permohonan = (new Permohonan)->getDetail(['id_permohonan' => $req->input('id_permohonan')])->first();
        if(!$permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $now = date('Y-m-d H:i:s');
        $sPermohonan = (new SPermohonan);
        $dt_process = [
            'sts_lanjut'            => $req->input('sts_permohonan'),
            'wkt_process'           => $now,
            'catatan'               => $req->input('catatan'),
            'is_deadline_manual'    => $req->input('is_deadline_manual'),
            'jam_deadline'          => $req->input('jam_deadline'),
            'tgl_deadline'          => $req->input('tgl_deadline')
        ];

        $sPermohonan->prosesPerjalanan($permohonan, $dt_process);

        $permohonan_ext = PermohonanExt::find($req->input('id_permohonan'));

        $permohonan_ext->no_nd_st_tim_penilai = $req->input('no_nd_st_tim_penilai');
        $permohonan_ext->tgl_nd_st_tim_penilai = $req->input('tgl_nd_st_tim_penilai');
        $permohonan_ext->hal_nd_st_tim_penilai = $req->input('hal_nd_st_tim_penilai');

        $permohonan_ext->no_nd_survey_tim_penilai = $req->input('no_nd_survey_tim_penilai');
        $permohonan_ext->tgl_nd_survey_tim_penilai = $req->input('tgl_nd_survey_tim_penilai');
        $permohonan_ext->hal_nd_survey_tim_penilai = $req->input('hal_nd_survey_tim_penilai');

        $permohonan_ext->updated_by = Auth::user()->id;
        $permohonan_ext->save();

        BApp::log('Melakukan Konfirmasi Proses '.$permohonan->nm_tahap_aktif.'.', $req->except('_token'));

        return redirect(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]))->with('alert', ['success', 'Berhasil memproses data permohonan <strong>'.$permohonan->no_permohonan.'</strong>']);
    }

    public function formStTimPenilai($id)
    {
        $data = $this->data;
        $data['permohonan'] = (new Permohonan)->getDetail(['id_permohonan' => $id])->first();
        if(!$data['permohonan'])
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }
        $data['permohonan_ext'] = PermohonanExt::find($id);

        $data['title'] = 'Form '.$data['permohonan']->nm_tahap_aktif;
        $data['subtitle'] = 'Lengkapi Form '.$data['permohonan']->nm_tahap_aktif.' Berikut';

        $data['next_tahap'] = (new TahapMonitoring)->getNextTahap($data['permohonan']->id_tahap_aktif);
        $data['next_deadline'] = $data['now'];
        if($data['next_tahap'])
        {
            $data['next_deadline'] = (new SPermohonan)->getNextDeadline($data['next_tahap']->urutan_tahap, $data['now']);
        }

        $data['allow_save'] = true;
        $data['ref_sts_permohonan'] = (new Perjalanan)->ref_sts_perjalanan;

        return view('MonitoringKpknl::perjalanan.form-stugas-tim-penilai', $data);
    }

    public function postStTimPenilai(Request $req)
    {
        $perjalanan = new Perjalanan();

        $rules = $perjalanan->validation_data();
        $rules['no_st_tim_penilai'] = 'required|string';
        $rules['tgl_st_tim_penilai'] = 'required|date';
        $rules['hal_st_tim_penilai'] = 'required|string';
        $rules['jadwal_survey'] = 'required|date';
        $this->validate($req, $rules);

        $permohonan = (new Permohonan)->getDetail(['id_permohonan' => $req->input('id_permohonan')])->first();
        if(!$permohonan)
        {
            return redirect()->back()->withInput()->with('alert', ['danger', 'Data Permohonan tidak ditemukan!']);
        }

        $now = date('Y-m-d H:i:s');
        $sPermohonan = (new SPermohonan);
        $dt_process = [
            'sts_lanjut'            => $req->input('sts_permohonan'),
            'wkt_process'           => $now,
            'catatan'               => $req->input('catatan'),
            'is_deadline_manual'    => $req->input('is_deadline_manual'),
            'jam_deadline'          => $req->input('jam_deadline'),
            'tgl_deadline'          => $req->input('tgl_deadline')
        ];

        $sPermohonan->prosesPerjalanan($permohonan, $dt_process);

        $permohonan_ext = PermohonanExt::find($req->input('id_permohonan'));
        $permohonan_ext->no_st_tim_penilai = $req->input('no_st_tim_penilai');
        $permohonan_ext->tgl_st_tim_penilai = $req->input('tgl_st_tim_penilai');
        $permohonan_ext->hal_st_tim_penilai = $req->input('hal_st_tim_penilai');
        $permohonan_ext->jadwal_survey = $req->input('jadwal_survey');
        $permohonan_ext->updated_by = Auth::user()->id;
        $permohonan_ext->save();

        BApp::log('Melakukan Konfirmasi Proses '.$permohonan->nm_tahap_aktif.'.', $req->except('_token'));

        return redirect(route('perjalanan_permohonan.detail-get.read', ['no_permohonan' => base64_encode($permohonan->no_permohonan)]))->with('alert', ['success', 'Berhasil memproses data permohonan <strong>'.$permohonan->no_permohonan.'</strong>']);
    }

}
