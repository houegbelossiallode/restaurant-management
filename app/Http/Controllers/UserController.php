<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role_id' => 'required|exists:roles,id',
        ], [
            'name.required' => 'Le nom est requis',
            'email.required' => 'L\'email est requis',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'role_id.required' => 'Le rôle est requis',
            'role_id.exists' => 'Le rôle sélectionné n\'existe pas',
        ]);

        // Générer un mot de passe aléatoire
        $password = Str::random(12);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role_id' => $request->role_id,
        ]);

        // Envoyer l'email avec la vue
        try {
            Mail::send('emails.user-created', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Votre compte a été créé');
            });
        } catch (\Throwable $exception) {
            Log::warning('Échec de l’envoi du courriel de création de compte.', [
                'user_id' => $user->id,
                'exception' => $exception::class,
            ]);

            return redirect()->route('users.index')->with('error', 'Utilisateur créé, mais le courriel n’a pas été envoyé. Vérifiez les paramètres SMTP et les journaux de Render.');
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès. Un email avec le mot de passe a été envoyé.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ], [
            'name.required' => 'Le nom est requis',
            'email.required' => 'L\'email est requis',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'role_id.required' => 'Le rôle est requis',
            'role_id.exists' => 'Le rôle sélectionné n\'existe pas',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
