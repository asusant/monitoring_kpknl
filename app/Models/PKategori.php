<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PKategori extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'p_kategori';
	protected $primaryKey = 'id_kategori';
    protected $fillable = ['nm_kategori', 'desc_kategori', 'img_kategori'];

    public static function validation_data($update_id = "NULL") {
        $rules = [
	        'nm_kategori'       => 'required|string:max:192',
	        'desc_kategori'     => 'required|string',
	        'img_kategori'      => 'required|string'
        ];
        if($update_id != 'NULL')
        {
            $rules['img_kategori'] = 'nullable|string';
        }
        return $rules;
    }
}
