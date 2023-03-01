<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ConfigApi;

class ConfigApiController extends Controller
{

    public function index(){
        return ConfigApi::all();
    }

    public function show($id){
        return ConfigApi::find($id);
    }

    public function store(Request $request){
        return ConfigApi::create($request->all());
    }

    public function update(Request $request, $id){
        $configApi = ConfigApi::findOrFail($id);
        $configApi->update($request->all());
        return $configApi;
    }

    public function delete(Request $request, $id){
        $configApi = ConfigApi::findOrFail($id);
        $configApi->delete();
        return 204;
    }

}
