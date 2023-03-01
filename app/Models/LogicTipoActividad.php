<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicTipoActividad extends Model
{
    use HasFactory;
    protected $table    = "logic_tipos_actividades";
    protected $primaryKey = 'id';
    protected $fillable = ['codigo','nombre','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
