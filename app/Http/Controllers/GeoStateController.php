<?php

namespace App\Http\Controllers;

use App\Models\GeoState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeoStateController extends Controller
{
    public function index(){
        return GeoState::all();
    }

    public function show($id){
        return GeoState::find($id);
    }

    public function store(Request $request){
        return GeoState::create($request->all());
    }

    public function update(Request $request, $id){
        $geoState = GeoState::findOrFail($id);
        $geoState->update($request->all());
        return $geoState;
    }

    public function delete(Request $request, $id){
        $geoState = GeoState::findOrFail($id);
        $geoState->delete();
        return 204;
    }

    public function getStates(Request $request){
        $pais = $request->pais;
            $query = " SELECT
                s.id AS ID,
                s.name AS REGION
            FROM geo_states s
            INNER JOIN geo_countries c ON c.id = s.country_id
            WHERE c.id = $pais";
            $data = DB::select($query);
            $result = [];
            foreach($data as $val){
                $result[$val->REGION] = $val->ID;
            }
        return json_encode(array('error'=>false, 'output' => $result));
    }
}
