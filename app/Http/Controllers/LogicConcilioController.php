<?php

namespace App\Http\Controllers;
use App\Models\LogicConcilio;
use Illuminate\Http\Request;

class LogicConcilioController extends Controller
{
    public function index(){
        return LogicConcilio::all();
    }

    public function show($id){
        return LogicConcilio::find($id);
    }

    public function store(Request $request){
        return LogicConcilio::create($request->all());
    }

    public function update(Request $request, $id){
        $LogicConcilio = LogicConcilio::findOrFail($id);
        $LogicConcilio->update($request->all());
        return $LogicConcilio;
    }

    public function delete(Request $request, $id){
        $LogicConcilio = LogicConcilio::findOrFail($id);
        $LogicConcilio->delete();
        return 204;
    }
}
