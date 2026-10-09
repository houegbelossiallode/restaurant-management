<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('menus')->get();
        return view('modules.index', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        Module::create($validated);
        return redirect()->route('modules.index')->with('success', 'Module ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        $module = Module::findOrFail($id);
        $module->update($validated);
        return redirect()->route('modules.index')->with('success', 'Module modifié avec succès.');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.index')->with('success', 'Module supprimé avec succès.');
    }
}
