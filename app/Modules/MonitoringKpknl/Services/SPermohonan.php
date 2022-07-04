<?php

namespace App\Modules\MonitoringKpkNl\Services;

use App\Bobb\Libs\BApp;
use App\Modules\MonitoringKpkNl\Models\Perjalanan;
use App\Modules\MonitoringKpkNl\Models\TahapMonitoring;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SPermohonan
{
    public function getNextDeadline($urutan_next, $date_from)
    {
        $next = TahapMonitoring::where('urutan_tahap', $urutan_next)->first();
        if(!$next)
        {
            return false;
        }
        return date('Y-m-d H:i:s', strtotime($date_from." + ".$next->deadline_hari." days ".$next->deadline_jam." hours"));
    }

    public function getNextTahap($current_urutan_tahap)
    {
        return TahapMonitoring::where('urutan_tahap', $current_urutan_tahap + 1)->first();
    }

    public function getData()
    {
        $q = DB::table('permohonan as a')
            ->join('tahap_monitoring as b', 'a.id_tahap_sebelum', 'b.id_tahap')
            ->leftJoin('tahap_monitoring as c', 'a.id_tahap_aktif', 'c.id_tahap')
            ->leftJoin('permohonan_ext as e', 'a.id_permohonan', 'e.id_permohonan')
            ->leftJoin('tim_penilaian as d', 'e.id_ketua_tim', 'd.id_tim_penilaian')
            ->whereNull('a.deleted_at')
            ->whereNull('b.deleted_at')
            ->whereNull('c.deleted_at')
            ->get([
                'a.*',
                'b.nm_tahap as nm_tahapan_sebelum',
                'c.nm_tahap as nm_tahapan_aktif',
                DB::raw('IF( e.id_ketua_tim is null, "N.A", CONCAT(nm_tim_penilaian, " (", nip_tim_penilaian, ")") ) as ketua_tim'),
                'e.jadwal_survey'
            ]);

        return $q;
    }

    public function prosesPerjalanan($permohonan, $dt_process, $manual_next_tahap = null)
    {
        $tahap = TahapMonitoring::find($permohonan->id_tahap_aktif);
        if($manual_next_tahap && $manual_next_tahap > 0)
        {
            $next_tahap = TahapMonitoring::find($manual_next_tahap);
        }
        else
        {
            switch ($dt_process['sts_lanjut']) {
                case 1:
                    $next_tahap = (new TahapMonitoring)->getNextTahap($permohonan->id_tahap_aktif);
                    break;
                default:
                    $next_tahap = $tahap;
                    break;
            }
        }

        // get current perjalanan
        $current = (new Perjalanan())->getPerjalanan($permohonan->id_permohonan, ['id_tahap' => $tahap->id_tahap])->first();

        // update current
        $current->sts_perjalanan = $dt_process['sts_lanjut'];
        $current->id_user_perjalanan = Auth::user()->id_user;
        $current->catatan = $dt_process['catatan'];
        $current->wkt_selesai_perjalanan = $dt_process['wkt_process'];
        $current->updated_at = $dt_process['wkt_process'];
        $current->updated_by = Auth::user()->id_user;
        $current->save();

        // update permohonan
        $permohonan->id_tahap_sebelum = $permohonan->id_tahap_aktif;
        $permohonan->proses_tahap_sebelum = $dt_process['wkt_process'];
        $permohonan->id_user_tahap_sebelum = Auth::user()->id_user;

        // next || belum selesai
        $ret = NULL;
        if($next_tahap)
        {
            if($dt_process['is_deadline_manual'])
            {
                $next_deadline = date('Y-m-d H:i:s', strtotime($dt_process['tgl_deadline'].' '.$dt_process['jam_deadline'].':00:00'));
            }
            else
            {
                $next_deadline = $this->getNextDeadline($next_tahap->urutan_tahap, $dt_process['wkt_process']);
            }

            $next = (new Perjalanan());
            $next->id_permohonan = $permohonan->id_permohonan;
            $next->id_tahap = $next_tahap->id_tahap;
            $next->wkt_mulai_perjalanan = $dt_process['wkt_process'];
            $next->sts_perjalanan = 0;
            $next->is_deadline_manual = $dt_process['is_deadline_manual'];
            $next->next_deadline = $next_deadline;
            $next->created_by = Auth::user()->id_user;
            $next->save();

            $permohonan->id_tahap_aktif = $next_tahap->id_tahap;
            $permohonan->deadline_tahap_aktif = $next_deadline;

            $ret = $next;
        }
        else
        {
            $permohonan->id_tahap_aktif = (int) @$next_tahap->id_tahap + 0;
            $permohonan->deadline_tahap_aktif = $dt_process['wkt_process'];
            $permohonan->sts_permohonan = 9;
        }

        $permohonan->updated_by = Auth::user()->id_user;
        $permohonan->save();

        BApp::log('Memproses permohonan '.$permohonan->no_permohonan.'. id='.$permohonan->id_permohonan.'.', ['permohonan' => $permohonan, 'dt_process' => $dt_process, 'manual_next_tahap' => $manual_next_tahap]);

        return $ret;
    }
}
