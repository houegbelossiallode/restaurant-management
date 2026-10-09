<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\Sousmenu;
use Illuminate\Support\Facades\DB;

class SousmenuObserver
{
    /**
     * Handle the Sousmenu "created" event.
     */
    public function created(Sousmenu $sousmenu): void
    {
         // Récupérer tous les rôles existants
         $roles = Role::all();
         foreach ($roles as $role) {
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
    }

    /**
     * Handle the Sousmenu "updated" event.
     */
    public function updated(Sousmenu $sousmenu): void
    {
        //
    }

    /**
     * Handle the Sousmenu "deleted" event.
     */
    public function deleted(Sousmenu $sousmenu): void
    {
        //
    }

    /**
     * Handle the Sousmenu "restored" event.
     */
    public function restored(Sousmenu $sousmenu): void
    {
        //
    }

    /**
     * Handle the Sousmenu "force deleted" event.
     */
    public function forceDeleted(Sousmenu $sousmenu): void
    {
        //
    }
}
