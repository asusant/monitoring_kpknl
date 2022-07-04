<?php

namespace App\Modules\MonitoringKpkNl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimPenilaiPermohonan extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'tim_penilai_permohonan';
    protected $primaryKey = 'id_tim_penilai_permohonan';
    protected $fillable = ['id_permohonan', 'id_tim_penilai', 'is_ketua', 'created_by', 'updated_by', 'deleted_by'];

    public static function validation_data($update_id = "NULL") {
        return [
	        'id_permohonan'         => 'required|numeric',
	        'id_tim_penilai' 	    => 'required|numeric',
	        'is_ketua' 	            => 'required|in:0,1'
        ];
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getPenilai($filters = [])
    {
        $t = $this->table;
        $q = self::join('tim_penilaian as b', $t.'.id_tim_penilai', 'b.id_tim_penilaian')
            ->select(
                $t.'.*',
                'b.nm_tim_penilaian',
                'b.nip_tim_penilaian'
            );

        extract($filters);
        if(isset($id_permohonan))
        {
            $q->where($t.'.id_permohonan', $id_permohonan);
        }
        if(isset($id_tim_penilai))
        {
            $q->where($t.'.id_tim_penilai', $id_tim_penilai);
        }

        return $q->get();
    }

}
