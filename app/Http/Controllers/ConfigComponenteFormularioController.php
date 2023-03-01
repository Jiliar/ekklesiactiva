<?php

namespace App\Http\Controllers;
use App\Models\ConfigComponenteFormulario;
use Illuminate\Http\Request;

class ConfigComponenteFormularioController extends Controller
{
    public function index(){
        return ConfigComponenteFormulario::all();
    }

    public function show($id){
        return ConfigComponenteFormulario::find($id);
    }

    public function store(Request $request){
        return ConfigComponenteFormulario::create($request->all());
    }

    public function update(Request $request, $id){
        $ConfigComponenteFormulario = ConfigComponenteFormulario::findOrFail($id);
        $ConfigComponenteFormulario->update($request->all());
        return $ConfigComponenteFormulario;
    }

    public function delete(Request $request, $id){
        $ConfigComponenteFormulario = ConfigComponenteFormulario::findOrFail($id);
        $ConfigComponenteFormulario->delete();
        return 204;
    }
}
