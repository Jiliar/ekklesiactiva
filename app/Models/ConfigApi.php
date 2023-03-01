<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigApi extends Model
{
    use HasFactory;
    protected $table    = "config_api";
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion','url','puerto','metodo','parametros','return'];
}
