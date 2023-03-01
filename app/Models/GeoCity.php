<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoCity extends Model
{
    use HasFactory;
    protected $table    = "geo_cities";
    protected $primaryKey = 'id';
    protected $fillable = ['name','state_id','state_code','country_id','country_code','latitude','longitude','created_at','updated_at','flag','wikiDataId','inactivo','acceso'];
}
