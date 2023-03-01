<?php

namespace App\Http\Controllers;
use App\Models\AuthTipoId;
use Illuminate\Http\Request;

class AuthTipoIdController extends Controller
{
    public function index(){
        return AuthTipoId::all();
    }

    public function show($id){
        return AuthTipoId::find($id);
    }

    public function store(Request $request){
        return AuthTipoId::create($request->all());
    }

    public function update(Request $request, $id){
        $AuthTipoId = AuthTipoId::findOrFail($id);
        $AuthTipoId->update($request->all());
        return $AuthTipoId;
    }

    public function delete(Request $request, $id){
        $AuthTipoId = AuthTipoId::findOrFail($id);
        $AuthTipoId->delete();
        return 204;
    }
}
