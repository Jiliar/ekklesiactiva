<?php

namespace App\Http\Controllers;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(){
        return MenuItem::all();
    }

    public function show($id){
        return MenuItem::find($id);
    }

    public function store(Request $request){
        return MenuItem::create($request->all());
    }

    public function update(Request $request, $id){
        $MenuItem = MenuItem::findOrFail($id);
        $MenuItem->update($request->all());
        return $MenuItem;
    }

    public function delete(Request $request, $id){
        $MenuItem = MenuItem::findOrFail($id);
        $MenuItem->delete();
        return 204;
    }
}
