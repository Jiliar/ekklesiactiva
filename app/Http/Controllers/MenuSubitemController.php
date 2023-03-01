<?php

namespace App\Http\Controllers;
use App\Models\MenuSubitem;
use Illuminate\Http\Request;

class MenuSubitemController extends Controller
{
    public function index(){
        return MenuSubitem::all();
    }

    public function show($id){
        return MenuSubitem::find($id);
    }

    public function store(Request $request){
        return MenuSubitem::create($request->all());
    }

    public function update(Request $request, $id){
        $MenuSubitem = MenuSubitem::findOrFail($id);
        $MenuSubitem->update($request->all());
        return $MenuSubitem;
    }

    public function delete(Request $request, $id){
        $MenuSubitem = MenuSubitem::findOrFail($id);
        $MenuSubitem->delete();
        return 204;
    }
}
