<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoState extends Model
{
    use HasFactory;
    protected $table    = "geo_states";
    protected $primaryKey = 'id';
    protected $fillable =['name','country_id','country_code','fips_code','iso2','type','latitude','longitude','created_at','updated_at','flag','wikiDataId','inactivo','acceso'];
}
