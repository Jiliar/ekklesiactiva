<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicNotificacion extends Model
{
    use HasFactory;
    protected $table    = "logic_notificacioness";
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','descripcion','asunto','cuerpo_mensaje','adjunto','etiqueta'];
}
