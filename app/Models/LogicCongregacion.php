<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicCongregacion extends Model
{
    use HasFactory;
    protected $table    = "logic_congregaciones";
    protected $primaryKey = 'id';
    protected $fillable = ['nit','nombre','direccion','telefono','email','seccional','distrito','id_concilio','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
