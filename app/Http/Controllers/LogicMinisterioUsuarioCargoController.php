<?php

namespace App\Http\Controllers;
use App\Models\LogicMinisterioUsuarioCargo;
use Illuminate\Http\Request;

class LogicMinisterioUsuarioCargoController extends Controller
{
    public function index(){
        return LogicMinisterioUsuarioCargo::all();
    }

    public function show($id){
        return LogicMinisterioUsuarioCargo::find($id);
    }

    public function store(Request $request){
        return LogicMinisterioUsuarioCargo::create($request->all());
    }

    public function update(Request $request, $id){
        $LogicMinisterioUsuarioCargo = LogicMinisterioUsuarioCargo::findOrFail($id);
        $LogicMinisterioUsuarioCargo->update($request->all());
        return $LogicMinisterioUsuarioCargo;
    }

    public function delete(Request $request, $id){
        $LogicMinisterioUsuarioCargo = LogicMinisterioUsuarioCargo::findOrFail($id);
        $LogicMinisterioUsuarioCargo->delete();
        return 204;
    }
}
