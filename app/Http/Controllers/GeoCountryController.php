<?php

namespace App\Http\Controllers;

use App\Models\GeoCountry;
use Illuminate\Http\Request;

class GeoCountryController extends Controller
{
    public function index(){
        return GeoCountry::all();
    }

    public function show($id){
        return GeoCountry::find($id);
    }

    public function store(Request $request){
        return GeoCountry::create($request->all());
    }

    public function update(Request $request, $id){
        $GeoCountry = GeoCountry::findOrFail($id);
        $GeoCountry->update($request->all());
        return $GeoCountry;
    }

    public function delete(Request $request, $id){
        $GeoCountry = GeoCountry::findOrFail($id);
        $GeoCountry->delete();
        return 204;
    }
}
