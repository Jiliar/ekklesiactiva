<?php

namespace App\Http\Controllers;
use App\Models\AudCorreo;
use Illuminate\Http\Request;

class AudCorreoController extends Controller
{
    public function index(){
        return AudCorreo::all();
    }

    public function show($id){
        return AudCorreo::find($id);
    }

    public function store(Request $request){
        return AudCorreo::create($request->all());
    }

    public function update(Request $request, $id){
        $AudCorreo = AudCorreo::findOrFail($id);
        $AudCorreo->update($request->all());
        return $AudCorreo;
    }

    public function delete(Request $request, $id){
        $AudCorreo = AudCorreo::findOrFail($id);
        $AudCorreo->delete();
        return 204;
    }
}
