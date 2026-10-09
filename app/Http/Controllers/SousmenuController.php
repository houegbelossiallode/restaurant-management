<?php

namespace App\Http\Controllers;

use App\Models\Sousmenu;
use App\Models\Menu;
use Illuminate\Http\Request;

class SousmenuController extends Controller
{
    public function index()
    {
        $sousmenus = Sousmenu::with(['menu', 'menu.module'])->get();
        $menus = Menu::with('module')->get();
        return view('sousmenus.index', compact('sousmenus', 'menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'menu_id' => 'required|exists:menus,id',
            'is_show' => 'required|in:OUI,NON',
        ]);

        Sousmenu::create($validated);
        return redirect()->route('sousmenus.index')->with('success', 'Sous-menu ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'menu_id' => 'required|exists:menus,id',
            'is_show' => 'required|in:OUI,NON',
        ]);

        $sousmenu = Sousmenu::findOrFail($id);
        $sousmenu->update($validated);
        return redirect()->route('sousmenus.index')->with('success', 'Sous-menu modifié avec succès.');
    }

    public function destroy(Sousmenu $sousmenu)
    {
        $sousmenu->delete();
        return redirect()->route('sousmenus.index')->with('success', 'Sous-menu supprimé avec succès.');
    }
}
