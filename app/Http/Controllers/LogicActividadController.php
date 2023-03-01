<?php

namespace App\Http\Controllers;
use App\Models\LogicActividad;
use Illuminate\Http\Request;

class LogicActividadController extends Controller
{
    public function index(){
        return LogicActividad::all();
    }

    public function show($id){
        return LogicActividad::find($id);
    }

    public function store(Request $request){
        return LogicActividad::create($request->all());
    }

    public function update(Request $request, $id){
        $LogicActividad = LogicActividad::findOrFail($id);
        $LogicActividad->update($request->all());
        return $LogicActividad;
    }

    public function delete(Request $request, $id){
        $LogicActividad = LogicActividad::findOrFail($id);
        $LogicActividad->delete();
        return 204;
    }
}
