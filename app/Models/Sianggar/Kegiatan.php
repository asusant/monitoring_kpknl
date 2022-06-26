<?php

namespace App\Models\Sianggar;

use Illuminate\Database\Eloquent\Model;
use DB;

class Kegiatan extends Model
{

	protected $connection = 'sianggar';
	protected $table = 'apl_transaksi';

	public static function getForSelect($filter = array())
    {
    	if(is_array($filter))
    	{
    		extract($filter);
    	}

        $q = self::select('kegiatan as nama', 'id');

        if(!isset($tahun))
        {
        	$tahun = config('bobb.tahun');
        }

        $q->where('tahun', $tahun-1);

        if(!isset($revisi))
        {
            $revisi = config('bobb.rev_sianggar');
        }

        $q->where('revisi', $revisi);

        if(!isset($unit))
        {
            $unit = config('bobb.unit_sianggar');
        }

        $q->where('unit', $unit);

        return $q->orderBy('kegiatan')
        	->pluck('nama', 'id')
        	->toArray();
    }

    // public static function getKegiatan($filter = array(), $query = false, $total_anggaran = false)
    // {
    //     if(is_array($filter))
    //     {
    //         extract($filter);
    //     }

    //     $q = self::select('*');

    //     if(!isset($tahun))
    //     {
    //         $tahun = Apl::getSesiApp('tahun');
    //     }

    //     $q->where('tahun', $tahun-1);

    //     if(!isset($revisi))
    //     {
    //         $revisi = Revisi::getRevisiAktif();
    //     }

    //     $q->where('revisi', $revisi);

    //     if(!isset($unit))
    //     {
    //         $unit = UnitSikeu::getKodeSianggar(Apl::getSesiApp('unit_sikeu'));
    //     }

    //     $q->where('unit', $unit);

    //     if(isset($id))
    //     {
    //         if(is_array($id))
    //         {
    //             $q->whereIn('id', $id);
    //         }
    //         else
    //         {
    //             $q->where('id', $id);
    //         }
    //     }

    //     if($query)
    //     {
    //         return $q;
    //     }

    //     if($total_anggaran)
    //     {
    //         $q->select();
    //         return $q->sum(DB::raw('(volume*harga_satuan)'));
    //     }

    //     return $q->orderBy('kegiatan')->get();
    // }

}
