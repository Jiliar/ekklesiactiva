<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicCms extends Model
{
    protected $table    = "logic_cms";
    protected $primaryKey = 'id';
    protected $fillable = ['titulo','contenido','tipo_cms','archivo','articulo_enlace','acceso','inactivo','created_at','usuario_registro','updated_at','usuario_actualizacion','deleted_at','usuario_eliminacion'];
}
