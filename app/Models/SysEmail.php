<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysEmail extends Model
{
    use HasFactory;
    protected $table = 'sys_email';
	protected $primaryKey = 'id_sys_email';
	protected $fillable = ['to', 'name', 'subject', 'content'];
}
