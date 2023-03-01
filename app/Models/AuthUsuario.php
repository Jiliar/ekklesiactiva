<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthUsuario extends Model
{
    use HasFactory;
    protected $table    = "auth_usuarios";
    protected $primaryKey = 'id';
    protected $fillable = ['tipo_id','identificación','nombre1','nombre2','apellido1','apellido2','email','telefono','direccion','congregacion','ciudad','estado_civil','nacimiento','escolaridad','es_bautizado','fecha_bautizado','usuario','password_jwt','password_app','archivo','id_perfil','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
