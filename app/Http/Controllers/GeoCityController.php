<?php

namespace App\Http\Controllers;

use App\Models\GeoCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeoCityController extends Controller
{
    public function index(){
        return GeoCity::all();
    }

    public function show($id){
        return GeoCity::find($id);
    }

    public function store(Request $request){
        return GeoCity::create($request->all());
    }

    public function update(Request $request, $id){
        $GeoCity = GeoCity::findOrFail($id);
        $GeoCity->update($request->all());
        return $GeoCity;
    }

    public function delete(Request $request, $id){
        $GeoCity = GeoCity::findOrFail($id);
        $GeoCity->delete();
        return 204;
    }

    public function getCities( Request $request){
        $region = $request->region;
        $query ="SELECT
            s.id AS ID,
            s.name AS CIUDAD
         FROM geo_cities s
         INNER JOIN geo_states t ON t.id = s.state_id
         WHERE t.id = $region";
        $data = DB::select($query);
        $result =[];
        foreach($data as $val){
            $result[$val->CIUDAD] = $val->ID;
        }
    return json_encode(array('error'=>false, 'output' => $result));


    }
}
