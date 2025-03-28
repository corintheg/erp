<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function dashboard()
    {
        $utilisateurs = Utilisateur::with('roles')->get();
        return view('admin.index', compact('utilisateurs'));
    }

    public function create()
    {
        $currentUser = Auth::user();
        if ($currentUser->hasRole('superadmin')) {
            $roles = Role::where('nom_role', '!=', 'superadmin')->get();
        } elseif ($currentUser->hasRole('admin')) {
            $roles = Role::whereNotIn('nom_role', ['superadmin', 'admin'])->get();
        } else {
            $roles = collect();
        }

        return view('admin.create', compact('roles'));
    }


    public function store(Request $request)
    {
        // Validation de base
        $request->validate([
            'username' => 'required|string|max:50|unique:utilisateurs,username',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|string|min:6|confirmed',
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

        // Création de l'utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->username = $request->input('username');
        $utilisateur->email = $request->input('email');
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

    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:50|unique:utilisateurs,username,'
                . $utilisateur->id_utilisateur . ',id_utilisateur',
            'email' => 'required|email|unique:utilisateurs,email,' . $utilisateur->id_utilisateur . ',id_utilisateur',
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
        $utilisateur->email = $request->input('email');
        if ($request->filled('password')) {
            $utilisateur->password = $request->input('password');
        }
        $utilisateur->save();


        $currentAssignedRoleIds = $utilisateur->roles()->pluck('roles.id_role')->toArray();

        $preservedRoles = array_filter($currentAssignedRoleIds, function ($roleId) use ($allowedRoleIds) {
            return !in_array($roleId, $allowedRoleIds);
        });

        $finalRoles = array_unique(array_merge($selectedRoles, $preservedRoles));

        if (!empty($finalRoles)) {
            $utilisateur->roles()->sync($finalRoles);
        } else {
            $utilisateur->roles()->detach();
        }

        return redirect()
            ->route('admin.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

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