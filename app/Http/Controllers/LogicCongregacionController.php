<?php

namespace App\Http\Controllers;
use App\Models\LogicCongregacion;
use Illuminate\Http\Request;

class LogicCongregacionController extends Controller
{
    public function index(){
        return LogicCongregacion::all();
    }

    public function show($id){
        return LogicCongregacion::find($id);
    }

    public function store(Request $request){
        return LogicCongregacion::create($request->all());
    }

    public function update(Request $request, $id){
        $LogicCongregacion = LogicCongregacion::findOrFail($id);
        $LogicCongregacion->update($request->all());
        return $LogicCongregacion;
    }

    public function delete(Request $request, $id){
        $LogicCongregacion = LogicCongregacion::findOrFail($id);
        $LogicCongregacion->delete();
        return 204;
    }
}
