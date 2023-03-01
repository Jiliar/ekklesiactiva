<?php

namespace App\Http\Controllers;
use App\Models\LogicTipoActividad;
use Illuminate\Http\Request;

class LogicTipoActividadController extends Controller
{
    public function index(){
        return LogicTipoActividad::all();
    }

    public function show($id){
        return LogicTipoActividad::find($id);
    }

    public function store(Request $request){
        return LogicTipoActividad::create($request->all());
    }

    public function update(Request $request, $id){
        $LogicTipoActividad = LogicTipoActividad::findOrFail($id);
        $LogicTipoActividad->update($request->all());
        return $LogicTipoActividad;
    }

    public function delete(Request $request, $id){
        $LogicTipoActividad = LogicTipoActividad::findOrFail($id);
        $LogicTipoActividad->delete();
        return 204;
    }
}
