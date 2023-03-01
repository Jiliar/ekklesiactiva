<?php

namespace App\Http\Controllers;
use App\Models\AuthPerfil;
use Illuminate\Http\Request;

class AuthPerfilController extends Controller
{
    public function index(){
        return AuthPerfil::all();
    }

    public function show($id){
        return AuthPerfil::find($id);
    }

    public function store(Request $request){
        return AuthPerfil::create($request->all());
    }

    public function update(Request $request, $id){
        $authPerfil = AuthPerfil::findOrFail($id);
        $authPerfil->update($request->all());
        return $authPerfil;
    }

    public function delete(Request $request, $id){
        $authPerfil = AuthPerfil::findOrFail($id);
        $authPerfil->delete();
        return 204;
    }
}
