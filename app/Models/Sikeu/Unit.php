<?php

namespace App\Models\Sikeu;

use Illuminate\Database\Eloquent\Model;
use DB;

class Unit extends Model
{

	protected $connection = 'sikeu';
	protected $table = 'tk_unit';
	protected $primaryKey = 'unit_id';

	public static function getForSelect($filter = array())
    {
    	if(is_array($filter))
    	{
    		extract($filter);
    	}

        $q = self::select(DB::raw('CONCAT(unit_id, " - ", unit_nama) as nama'), 'unit_id as id');

        if(isset($unit_ids))
        {
            $q->whereIn('unit_id', $unit_ids);
        }

        if(isset($unit_inc))
        {
        	$q->where('unit_inc', $unit_inc);
        }

        return $q->orderBy('unit_id')
        	->pluck('nama', 'id')
        	->toArray();
    }

    public static function getUnitArray($filter = array())
    {
        if(is_array($filter))
        {
            extract($filter);
        }

        $q = self::select('unit_nama as nama', 'unit_id as id');

        if(isset($unit_ids))
        {
            $q->whereIn('unit_id', $unit_ids);
        }

        if(isset($unit_inc))
        {
            $q->where('unit_inc', $unit_inc);
        }

        return $q->orderBy('unit_id')
            ->pluck('nama', 'id')
            ->toArray();
    }

    public static function getKodeSianggar($unit_id)
    {
    	$q = self::where('unit_id', $unit_id)->first();

    	if($q)
    	{
    		return str_replace(',', '', $q->kode_sianggar);
    	}

    	return 0;
    }

    public static function getUnitTree($unit_id, $with_induk = true)
    {
        if($unit_id == '7777')
        {
            $units = cache('ref_unit_sikeu');
        }
        else
        {
            $q = self::select('*');
            $q->where(function($w) use($unit_id, $with_induk){
                $w->where('unit_induk', $unit_id);
                if($with_induk)
                {
                    $w->orWhere('unit_id', $unit_id);
                }
            });
            $q->orderBy('unit_nama', 'asc');
            $dt = $q->get();

            $units = array();
            foreach ($dt as $r)
            {
                $units[$r->unit_id] = $r->unit_nama;
                $t = self::getUnitTree($r->unit_id, false);
                if(sizeof($t) > 0)
                {
                    $units = $units + $t;
                }
            }
        }

    	return $units;
    }

    public static function getUnitInduk($unit_id)
    {
        $un = self::find($unit_id);
        if($un->unit_induk && $un->unit_induk != '')
        {
            return self::find($un->unit_induk);
        }
        return $un;
    }

    public static function getAllUnitInduk()
    {
    	$un = self::all()->pluck('unit_induk', 'unit_id');
    	foreach ($un as $unit => $induk)
    	{
    		if(!$induk || $induk == '')
    		{
    			$un[$unit] = $unit;
    		}
    	}
    	return $un;
    }

    public static function getAllIndukChild()
    {
        $in = self::getAllUnitInduk();

        $dt = array();
        foreach ($in as $child => $induk)
        {
            if(!isset($dt[$induk]))
                $dt[$induk] = array();
            $dt[$induk][] = $child;
        }

        return $dt;
    }

}
