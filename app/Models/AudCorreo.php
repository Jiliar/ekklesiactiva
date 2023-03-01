<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudCorreo extends Model
{
    use HasFactory;
    protected $table    = "aud_correos";
    protected $primaryKey = 'id';
    protected $fillable = ['de','usuario_para','correo_para','asunto','cuerpo','fecha_envio','tipo_correo','inactivo'];
}
