<?php
// app/Http/Controllers/EmployeController.php
namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function create()
    {
        $employes = Employe::all();
        return view('employes.add_employe', compact('employes'));
    }
    public function index()
    {
        $employes = Employe::all();
        return view('employes.management', compact('employes'));
    }
    public function add_employe(Request $request)
    {
        $messages = [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L’email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'departement.required' => 'Veuillez choisir un département.',
            'telephone.required' => 'Le numéro est obligatoire.',
            'telephone.unique' => 'Le numéro est déjà utilisé.',
            'date_embauche.required' => 'La date d’embauche doit être une date valide.'
        ];
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:employes,email',
            'departement' => 'required|in:rh,finance,informatique,livraison,employe',
            'telephone' => 'required|string|max:20|unique:employes,telephone',
            'date_embauche' => 'required|date',
        ], $messages);
        $employe = new Employe();
        $employe->nom = $request->nom;
        $employe->prenom = $request->prenom;
        $employe->email = $request->email;
        $employe->telephone = $request->telephone;
        $employe->date_embauche = $request->date_embauche;
        $employe->departement = $request->departement;
        $employe->save();
        return redirect()->route('add_employe')->with('success', 'Demande de congé approuvée avec succès.');

    }
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'departement' => 'required|string',
            'date_embauche' => 'required|date',
            'date_debauche' => 'nullable|date|after_or_equal:date_embauche',
        ]);

        //dd($request->all());
        $employe = Employe::findOrFail($id);
        $employe->update($request->only([
            'nom',
            'prenom',
            'email',
            'departement',
            'date_embauche',
            'date_debauche'
        ]));

        return redirect()->route('employes.index')->with('success', 'Employé mis à jour avec succès.');
    }
}