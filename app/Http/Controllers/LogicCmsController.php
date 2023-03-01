<?php

namespace App\Http\Controllers;
use App\Models\LogicCms;
use Illuminate\Http\Request;

class LogicCmsController extends Controller
{
    public function index(){
        return LogicCms::all();
    }

    public function show($id){
        return LogicCms::find($id);
    }

    public function store(Request $request){
        return LogicCms::create($request->all());
    }

    public function update(Request $request, $id){
        $logicCms = LogicCms::findOrFail($id);
        $logicCms->update($request->all());
        return $logicCms;
    }

    public function delete(Request $request, $id){
        $logicCms = LogicCms::findOrFail($id);
        $logicCms->delete();
        return 204;
    }
}
