<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'mot_de_passe' => ['required'],
        ], [
            'username.required' => 'Le champ nom d’utilisateur est obligatoire.',
            'mot_de_passe.required' => 'Le champ mot de passe est obligatoire.',
        ]);


        $user = Utilisateur::where('username', $request->username)->first();

        if ($user && Hash::check($request->mot_de_passe, $user->getAuthPassword())) {
            Auth::login($user);
            $request->session()->regenerate();
            session()->flash('success', 'Connexion réussie !');
            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Les identifiants sont incorrects.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}