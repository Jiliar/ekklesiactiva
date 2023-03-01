<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicMinisterioUsuarioCargo extends Model
{
    use HasFactory;
    protected $table    = "logic_ministerios_usuarios_cargos";
    protected $primaryKey = 'id';
    protected $fillable = ['id_usuario','id_ministerio','id_cargo','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
