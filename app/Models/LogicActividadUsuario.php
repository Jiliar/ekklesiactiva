<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicActividadUsuario extends Model
{
    use HasFactory;
    protected $table    = "logic_actividades_usuarios";
    protected $primaryKey = 'id';
    protected $fillable = ['id_usuario','id_actividad','asistencia','observaciones','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
