<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Sousmenu;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roleid = request('roleid');
        if(empty($roleid)){
            return redirect()->route('roles.index')->with('error', 'Veuillez selectionner un profil.');
        }
        $role = Role::where('id',$roleid)->firstOrFail();

        // S'assurer que chaque sous-menu a bien une permission enregistrée pour ce rôle
        $sousmenus = Sousmenu::all();
        foreach ($sousmenus as $sousmenu) {
            $exists = DB::table('role_permissions')
                ->where('sous_menu_id', $sousmenu->id)
                ->where('role_id', $role->id)
                ->exists();

            if (!$exists) {
                DB::table('role_permissions')->insert([
                    'sous_menu_id' => $sousmenu->id,
                    'role_id'     => $role->id,
                    'is_granted'  => false,
                    'actif'       => 'OUI',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        $permissions = RolePermission::with(['sousmenu.menu'])->where('role_id', $role->id)->get();
        $modules = \App\Models\Module::with(['menus.sousmenus'])->get();
        return view('role-permissions.index', compact('permissions','role','modules'));
    }

    public function create()
    {
        $roles = Role::latest()->get();
        $sousmenus = Sousmenu::latest()->get();
        return view('role-permissions.create', compact('roles', 'sousmenus'));
    }

    public function store(Request $request)
    {
        try{
        $request->validate([
            'sous_menu_id' => 'required',
            'role_id' => 'required',
        ], [
            'sous_menu_id.required' => "Le champs est requis",
            'role_id.required' => "Le champs est requis",
        ]);

        RolePermission::create([
            'sous_menu_id' => $request->sousmenu_id,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('role-permissions.index')->with('success', 'Permission creée avec succès.');

    } catch (\Exception $e) {
        // Gestion des erreurs : redirection avec un message d'erreur
        return redirect()->route('role-permissions.index')->with(['error' => 'Une erreur inattendue s\'est produite : ' . $e->getMessage()]);
    }

    }


    public function edit(RolePermission $permission)
    {
        $roles = Role::latest()->get();
        $sousmenus = Sousmenu::latest()->get();
        return view('role-permissions.edit', compact('permission', 'roles', 'sousmenus'));
    }


    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        // Permissions cochées (ex : [3 => "1", 5 => "1"])
        $permissions = $request->input('permissions', []);
        // 1) Tout passer à false
        DB::table('role_permissions')
            ->where('role_id', $roleId)
            ->update(['is_granted' => false]);

        // 2) Activer ceux cochés
        foreach ($permissions as $permissionId => $value) {
            DB::table('role_permissions')
                ->where('role_id', $roleId)
                ->where('sous_menu_id', $permissionId)
                ->update(['is_granted' => true]);
        }
    return redirect()->route('roles.index')->with('success', 'Permissions mises à jour avec succès ✔');
    }

    public function destroy($rolePermission)
    {
        $permission = RolePermission::findOrFail($rolePermission);
        $permission->delete();

        return redirect()->route('role-permissions.index')->with('success', 'Permission supprimée avec succès.');
    }
}
