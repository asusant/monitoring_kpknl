<?php

namespace App\Models\Sikeu;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Helpers\Apl;

class Kegiatan extends Model
{

	protected $connection = 'sikeu';
	protected $table = 'tu_kegiatan';
	protected $primaryKey = 'k_id';
    protected $fillable = ['*'];
    public $timestamps = false;

    public static function getForSelect($filter = array())
    {
        if(is_array($filter))
        {
            extract($filter);
        }

        $q = self::select('k_keterangan as nama', 'k_id as id');

        if(!isset($tahun))
        {
            $tahun = config('bobb.tahun');
        }

        if(!isset($unit))
        {
            $unit = config('bobb.unit_asli');
        }

        if(isset($keg_sianggar))
        {
            $q->where('keg_sianggar_id', $keg_sianggar);
        }

        $q->where('k_unit_asli', $unit);
        $q->where('k_ta', substr($tahun, -2));

        return $q->orderBy('k_keterangan')
            ->pluck('nama', 'id')
            ->toArray();
    }
}
