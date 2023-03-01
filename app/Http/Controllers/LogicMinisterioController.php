<?php

namespace App\Http\Controllers;
use App\Models\LogicMinisterio;
use Illuminate\Http\Request;

class LogicMinisterioController extends Controller
{
    public function index(){
        return LogicMinisterio::all();
    }

    public function show($id){
        return LogicMinisterio::find($id);
    }

    public function store(Request $request){
        return LogicMinisterio::create($request->all());
    }

    public function update(Request $request, $id){
        $LogicMinisterio = LogicMinisterio::findOrFail($id);
        $LogicMinisterio->update($request->all());
        return $LogicMinisterio;
    }

    public function delete(Request $request, $id){
        $LogicMinisterio = LogicMinisterio::findOrFail($id);
        $LogicMinisterio->delete();
        return 204;
    }
}
