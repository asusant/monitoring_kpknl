<?php

namespace App\Modules\MonitoringKpkNl\Services;

use App\Modules\MonitoringKpkNl\Models\TahapMonitoring;
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

    public function getData()
    {
        $q = DB::table('permohonan as a')
            ->join('tahap_monitoring as b', 'a.id_tahap_sebelum', 'b.id_tahap')
            ->join('tahap_monitoring as c', 'a.id_tahap_aktif', 'c.id_tahap')
            ->whereNull('a.deleted_at')
            ->whereNull('b.deleted_at')
            ->whereNull('c.deleted_at')
            ->get([
                'a.*',
                'b.nm_tahap as nm_tahapan_sebelum',
                'c.nm_tahap as nm_tahapan_aktif'
            ]);

        return $q;
    }

    public function getPerjalananPermohonan()
    {
        # code...
    }
}
