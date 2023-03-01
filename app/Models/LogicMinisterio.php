<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicMinisterio extends Model
{
    use HasFactory;
    protected $table    = "logic_ministerios";
    protected $primaryKey = 'id';
    protected $fillable = ['codigo','nombre','id_congregacion','id_segmento','acceso','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
