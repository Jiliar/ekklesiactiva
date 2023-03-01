<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicCargo extends Model
{
    use HasFactory;
    protected $table    = "logic_cargos";
    protected $primaryKey = 'id';
    protected $fillable = ['codigo','nombre','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
