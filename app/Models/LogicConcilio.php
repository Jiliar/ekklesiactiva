<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicConcilio extends Model
{
    use HasFactory;
    protected $table    = "logic_concilios";
    protected $primaryKey = 'id';
    protected $fillable = ['nit','nombre','direccion','telefono','email','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
