<?php

namespace App\Http\Controllers;
use App\Models\LogicNotificacion;
use Illuminate\Http\Request;

class LogicNotificacionController extends Controller
{
    public function index(){
        return LogicNotificacion::all();
    }

    public function show($id){
        return LogicNotificacion::find($id);
    }

    public function store(Request $request){
        return LogicNotificacion::create($request->all());
    }

    public function update(Request $request, $id){
        $LogicNotificacion = LogicNotificacion::findOrFail($id);
        $LogicNotificacion->update($request->all());
        return $LogicNotificacion;
    }

    public function delete(Request $request, $id){
        $LogicNotificacion = LogicNotificacion::findOrFail($id);
        $LogicNotificacion->delete();
        return 204;
    }
}
