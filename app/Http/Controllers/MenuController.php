<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Module;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['module', 'sousmenus'])->get();
        $modules = Module::all();
        return view('menus.index', compact('menus', 'modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'icone' => 'nullable|string|max:255',
            'module_id' => 'required|exists:modules,id',
        ]);

        Menu::create($validated);
        return redirect()->route('menus.index')->with('success', 'Menu ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'icone' => 'nullable|string|max:255',
            'module_id' => 'required|exists:modules,id',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($validated);
        return redirect()->route('menus.index')->with('success', 'Menu modifié avec succès.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu supprimé avec succès.');
    }
}
