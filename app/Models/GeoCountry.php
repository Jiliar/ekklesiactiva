<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoCountry extends Model
{
    use HasFactory;
    protected $table    = "geo_countries";
    protected $primaryKey = 'id';
    protected $fillable =['name','iso3','numeric_code','iso2','phonecode','capital','currency','currency_name','currency_symbol','tld','native',
    'region','subregion','timezones','translations','latitude','longitude','emoji','emojiU','created_at','updated_at','flag','wikiDataId','inactivo','acceso'];
}
