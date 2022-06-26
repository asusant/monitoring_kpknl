<?php

namespace App\Models\Sikeu;

use Illuminate\Database\Eloquent\Model;
use DB;
use Apl;

class Pagu extends Model
{

	protected $connection = 'sikeu';
	protected $table = 'tu_pagu';
	protected $primaryKey = 'pagu_key';
    protected $fillable = ['*'];
    public $timestamps = false;

    public static function getTransito($ta, $unit)
    {
    	$pagu = self::where('pagu_ta', $ta)
    		->where('pagu_unit', $unit)
    		->where('pagu_mak', '825113')
    		->where('pagu_cb', '02')
    		->where('pagu_kegiatan', '0000')
    		->first();

    	return $pagu;
    }
}
