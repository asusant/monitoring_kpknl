<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SysPrivilege extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $incrementing = false;
	protected $dates = ['deleted_at'];
	protected $table = 'sys_privilege';
	protected $primaryKey = ['id_modul', 'id_role'];
    protected $fillable = ['id_modul', 'id_role', 'a_read', 'a_create', 'a_update', 'a_delete', 'a_validate', 'created_by', 'updated_by', 'deleted_by'];
}
