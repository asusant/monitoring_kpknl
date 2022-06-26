<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PItem extends Model
{
    use HasFactory;
    use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'p_item';
	protected $primaryKey = 'id_item';
    protected $fillable = ['id_kategori', 'nm_item', 'desc_item', 'max_stok', 'harga', 'desc_harga'];

    public static function validation_data($update_id = "NULL") {
        $rules = [
	        'id_kategori'   => 'required|exists:p_kategori,id_kategori',
	        'nm_item'       => 'required|string|max:192',
	        'desc_item'     => 'required|string',
	        'max_stok'      => 'required|numeric|min:0',
            'img_item'      => 'required',
            'img_item.*'    => 'string',
            'harga'         => 'required'
        ];
        if($update_id != 'NULL')
        {
            $rules['img_item'] = 'nullable';
        }
        return $rules;
    }
}
