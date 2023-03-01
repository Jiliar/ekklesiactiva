<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthPerfil extends Model
{
    use HasFactory;
    protected $table    = "auth_perfiles";
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','descripcion','menu_subitems','acceso','inactivo','created_at','user_create','apdated_at','user_update','deleted_at','user_inactive'];
}
