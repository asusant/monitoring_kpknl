<?php

namespace App\Models\Sianggar;

use Illuminate\Database\Eloquent\Model;
use DB;
use Apl;
use App\Models\Sianggar\Revisi;

class Unit extends Model
{

	protected $connection = 'sianggar';
	protected $table = 'apl_unit';

	public static function getForSelect($filter = array())
    {
    	if(is_array($filter))
    	{
    		extract($filter);
    	}

        $q = self::select('nama', 'kode as id');

        if(!isset($tahun))
        {
        	$tahun = session()->get('bobb_active_tahun');
        }

        $q->where('tahun', $tahun-1);

        return $q->orderBy('nama')
        	->pluck('nama', 'id')
        	->toArray();
    }

    public static function getRowUnit($filter = array())
    {
        if(is_array($filter))
        {
            extract($filter);
        }

        $q = self::select('*');

        if(!isset($tahun))
        {
            $tahun = session()->get('bobb_active_tahun');
        }

        $q->where('tahun', $tahun-1);

        if(isset($unit_sikeu))
        {
            $q->where('unit_sikeu', $unit_sikeu);
        }

        if(isset($kode))
        {
            $q->where('kode', $kode);
        }

        return $q->first();
    }

}
