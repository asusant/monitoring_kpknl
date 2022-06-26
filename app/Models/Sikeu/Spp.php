<?php

namespace App\Models\Sikeu;

use Illuminate\Database\Eloquent\Model;
use DB;
use Apl;

class Spp extends Model
{

	protected $connection = 'sikeu';
	protected $table = 'tu_spp';
	protected $primaryKey = 'id';
    protected $fillable = ['*'];
    public $timestamps = false;

    public static function getTotalUp($unit,$ta,$bulan)
    {
    	$q = self::join('tu_transaksi as b', 'tu_spp.id', 'b.transaksi_spp')
            ->where('tu_spp.ta', $ta)
            ->where('tu_spp.unit', $unit)
    		->whereIn('jenis', [1,3]); # UP & TUP

        if($bulan != '')
        {
            if(is_array($bulan))
            {
                $q->whereIn('spp_bulan', $bulan);
            }
            else
            {
                $q->where('spp_bulan', $bulan);
            }
        }

        $total = $q->sum('transaksi_jumlah');

    	return $total;
    }
}
