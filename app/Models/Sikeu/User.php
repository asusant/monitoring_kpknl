<?php

namespace App\Models\Sikeu;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{

	protected $connection = 'sikeu';
	protected $table = 'user';
	protected $primaryKey = 'user_id';
	public static $mappingLevel = array(
        // RPD => Sikeu
		2	=> 1, # Admin
		3	=> 8, # Op. Unit
		4	=> 27, # Op. Subunit
		6	=> 29, # PPK
		7	=> 30, # Staff PPK
        8	=> 6, # Penguji
        9   => 25 # BPP
	);

	public static function getUser($identitas)
	{
        $t = (new self)->table;
        return self::join('tk_unit as b', $t.'.unit_kode', '=', 'b.unit_id')
            ->where('user_nip', $identitas)
            ->where('user_aktif', 1)
			->whereIn('level_id', self::$mappingLevel)
			->get([$t.'.*']);
	}

}
