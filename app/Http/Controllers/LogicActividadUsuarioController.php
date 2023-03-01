<?php

namespace App\Http\Controllers;
use App\Models\LogicActividadUsuario;
use Illuminate\Http\Request;

class LogicActividadUsuarioController extends Controller
{
    public function index(){
        return LogicActividadUsuario::all();
    }

    public function show($id){
        return LogicActividadUsuario::find($id);
    }

    public function store(Request $request){
        return LogicActividadUsuario::create($request->all());
    }

    public function update(Request $request, $id){
        $LogicActividadUsuario = LogicActividadUsuario::findOrFail($id);
        $LogicActividadUsuario->update($request->all());
        return $LogicActividadUsuario;
    }

    public function delete(Request $request, $id){
        $LogicActividadUsuario = LogicActividadUsuario::findOrFail($id);
        $LogicActividadUsuario->delete();
        return 204;
    }
}
