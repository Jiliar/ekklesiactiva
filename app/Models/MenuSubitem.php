<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSubitem extends Model
{
    use HasFactory;
    protected $table    = "menu_subitems";
    protected $primaryKey = 'id';
    protected $fillable = ['id_item','abreviado','descripcion','archivo','ruta','etiqueta','depende','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
