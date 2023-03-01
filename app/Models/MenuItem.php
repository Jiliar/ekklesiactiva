<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $table    = "menu_items";
    protected $primaryKey = 'id';
    protected $fillable = ['modulo_categoria','modulo_nombre','icono','ruta','orden','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
