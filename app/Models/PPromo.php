<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PPromo extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'p_promo_header';
	protected $primaryKey = 'id_promo';
    protected $fillable = ['nm_promo', 'desc_promo', 'img_promo'];

    public static function validation_data($update_id = "NULL") {
        $rules = [
	        'nm_promo'       => 'required|string:max:192',
	        'desc_promo'     => 'required|string',
	        'img_promo'      => 'required|string'
        ];
        if($update_id != 'NULL')
        {
            $rules['img_promo'] = 'nullable|string';
        }
        return $rules;
    }
}
