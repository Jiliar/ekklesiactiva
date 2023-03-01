<?php

namespace App\Http\Controllers;
use App\Models\LogicCargo;
use Illuminate\Http\Request;

class LogicCargoController extends Controller
{
    public function index(){
        return LogicCargo::all();
    }

    public function show($id){
        return LogicCargo::find($id);
    }

    public function store(Request $request){
        return LogicCargo::create($request->all());
    }

    public function update(Request $request, $id){
        $LogicCargo = LogicCargo::findOrFail($id);
        $LogicCargo->update($request->all());
        return $LogicCargo;
    }

    public function delete(Request $request, $id){
        $LogicCargo = LogicCargo::findOrFail($id);
        $LogicCargo->delete();
        return 204;
    }
}
