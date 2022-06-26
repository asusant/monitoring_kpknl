<?php

namespace App\Models\Sikeu;

use Illuminate\Database\Eloquent\Model;
use DB;
use Apl;

class Setting extends Model
{

	protected $connection = 'sikeu';
	protected $table = 'tk_setting_unit';
	protected $primaryKey = 'unit_id';
    protected $fillable = ['*'];
    public $timestamps = false;

    public static function getSettingUnit($kode)
    {
        $now = date('Y-m-d');
        return self::where('unit_tanggal_mulai', '<', $now)->where('unit_kode', $kode)->orderBy('unit_tanggal_mulai', 'desc')->first();
    }
}
