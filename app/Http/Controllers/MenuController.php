<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
class MenuController extends Controller
{
    public function index()
    {
        $fronted = Menu::all();
        return view('admin.Themes.Frontend', compact('fronted'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        Menu::create($request->all());
        return redirect()->route('menus.index')->with('success', 'Menu Added');
    }
    function delete($id){

        Menu::destroy($id);
        return redirect()->route('menus.index');
    }
    public function edit($id)
    {
        $Fronted = Menu::findOrFail($id);

        return view('admin.Themes.EditFronted', compact('Fronted'));
    }
    public function update(Request $req,$id)
    {
        $menu = Menu::findOrFail($id);

        $menu->name = $req->name;
        $menu->link = $req->link;
        $menu->type = $req->type;



        $menu->save();

        return redirect('/menus')->with('success','menus Updated Successfully');
    }
}
