<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Affiche la liste des utilisateurs (index).
     * URL : GET /admin
     */
    public function dashboard()
    {
        $utilisateurs = Utilisateur::with('roles')->get();
        return view('admin.index', compact('utilisateurs'));
    }

    /**
     * Affiche le formulaire de création d'un nouvel utilisateur.
     * URL : GET /admin/create
     */
    public function create()
    {
        $currentUser = Auth::user();
        // Filtrer les rôles disponibles en fonction du rôle de l'utilisateur connecté
        if ($currentUser->hasRole('superadmin')) {
            // Le superadmin peut assigner tous les rôles sauf superadmin lui-même
            $roles = Role::where('nom_role', '!=', 'superadmin')->get();
        } elseif ($currentUser->hasRole('admin')) {
            // L'admin peut assigner tous les rôles sauf superadmin et admin
            $roles = Role::whereNotIn('nom_role', ['superadmin', 'admin'])->get();
        } else {
            // Autres profils : on peut choisir de ne proposer aucun rôle ou une liste réduite
            $roles = collect();
        }

        return view('admin.create', compact('roles'));
    }

    /**
     * Traite la création d'un nouvel utilisateur.
     * URL : POST /admin
     */
    public function store(Request $request)
    {
        // Validation de base
        $request->validate([
            'username' => 'required|string|max:50|unique:utilisateurs,username',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'nullable|array',
        ]);

        $currentUser = Auth::user();
        $selectedRoles = $request->input('roles', []);

        // Définir les rôles interdits selon le rôle de l'utilisateur connecté
        if ($currentUser->hasRole('admin')) {
            $forbiddenRoles = ['superadmin', 'admin'];
        } elseif ($currentUser->hasRole('superadmin')) {
            $forbiddenRoles = ['superadmin'];
        } else {
            $forbiddenRoles = [];
        }

        // Récupérer les IDs des rôles autorisés
        $allowedRoleIds = Role::whereNotIn('nom_role', $forbiddenRoles)
            ->pluck('id_role')
            ->toArray();

        // Vérifier que les rôles soumis sont autorisés
        foreach ($selectedRoles as $roleId) {
            if (!in_array($roleId, $allowedRoleIds)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['roles' => 'Vous n\'êtes pas autorisé à assigner ce rôle.']);
            }
        }

        // Création de l'utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->username = $request->input('username');
        // Le mutator du modèle hashera automatiquement le mot de passe
        $utilisateur->password = $request->input('password');
        $utilisateur->save();

        // Affecter les rôles sélectionnés
        if (!empty($selectedRoles)) {
            $utilisateur->roles()->attach($selectedRoles);
        }

        return redirect()
            ->route('admin.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un utilisateur.
     * URL : GET /admin/{id}/edit
     */
    public function edit($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $currentUser = Auth::user();

        if ($currentUser->hasRole('superadmin')) {
            $roles = Role::where('nom_role', '!=', 'superadmin')->get();
        } elseif ($currentUser->hasRole('admin')) {
            $roles = Role::whereNotIn('nom_role', ['superadmin', 'admin'])->get();
        } else {
            $roles = collect();
        }

        return view('admin.edit', compact('utilisateur', 'roles'));
    }

    /**
     * Traite la mise à jour d'un utilisateur existant.
     * URL : PUT /admin/{id}
     */
    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:50|unique:utilisateurs,username,'
                . $utilisateur->id_utilisateur . ',id_utilisateur',
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'nullable|array',
        ]);

        $currentUser = Auth::user();
        $selectedRoles = $request->input('roles', []);

        if ($currentUser->hasRole('admin')) {
            $forbiddenRoles = ['superadmin', 'admin'];
        } elseif ($currentUser->hasRole('superadmin')) {
            $forbiddenRoles = ['superadmin'];
        } else {
            $forbiddenRoles = [];
        }

        $allowedRoleIds = Role::whereNotIn('nom_role', $forbiddenRoles)
            ->pluck('id_role')
            ->toArray();

        foreach ($selectedRoles as $roleId) {
            if (!in_array($roleId, $allowedRoleIds)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['roles' => 'Vous n\'êtes pas autorisé à assigner ce rôle.']);
            }
        }

        $utilisateur->username = $request->input('username');

        if ($request->filled('password')) {
            $utilisateur->password = $request->input('password');
        }

        $utilisateur->save();

        // Synchroniser les rôles en fonction des rôles autorisés
        if (!empty($selectedRoles)) {
            $utilisateur->roles()->sync($selectedRoles);
        } else {
            $utilisateur->roles()->detach();
        }

        return redirect()
            ->route('admin.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur.
     * URL : DELETE /admin/{id}
     */
    public function destroy($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->roles()->detach();
        $utilisateur->delete();

        return redirect()
            ->route('admin.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}