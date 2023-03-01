<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicActividad extends Model
{
    use HasFactory;
    protected $table    = "logic_actividades";
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','descripcion','tipo_actividad','id_ministerio','fecha','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
