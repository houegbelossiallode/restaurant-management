<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('rolePermissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        Role::create($validated);
        return redirect()->route('roles.index')->with('success', 'Rôle ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->update($validated);
        return redirect()->route('roles.index')->with('success', 'Rôle modifié avec succès.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé avec succès.');
    }
}
