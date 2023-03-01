<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthTipoId extends Model
{
    use HasFactory;
    protected $table    = "auth_tipos_id";
    protected $primaryKey = 'id';
    protected $fillable = ['codigo','nombre','acceso','inactivo','created_at','user_create','update_at','user_update','deleted_at','user_inactive'];
}
