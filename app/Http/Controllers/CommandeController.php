<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::all();
        return view('commandes.index', compact('commandes'));
    }

    public function create()
    {
        // Liste des fournisseurs
        $fournisseurs = Fournisseur::all();

        // Liste des statuts possibles (vous pouvez lister les valeurs de l’ENUM)
        $statuts = ['En cours', 'Livré', 'Annulé'];

        return view('commandes.create', compact('fournisseurs', 'statuts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference_commande' => 'required|string|max:100',
            'id_fournisseur' => 'nullable|integer',
            'destinataire' => 'nullable|string|max:255',
            'statut_livraison' => 'required|string|max:50',
            'date_livraison' => 'nullable|date',
        ]);


        Commande::create($data);

        return redirect()->route('commandes.index')
            ->with('success', 'Commande créée avec succès !');
    }



    public function edit($id)
    {
        $commande = Commande::findOrFail($id);
        $fournisseurs = Fournisseur::all();
        $statuts = ['En cours', 'Livré', 'Annulé'];

        return view('commandes.edit', compact('commande', 'fournisseurs', 'statuts'));
    }

    public function update(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);

        $request->validate([
            'reference_commande' => 'required|string|max:100',
            'id_fournisseur' => 'nullable|integer',
            'statut_livraison' => 'required|string|max:50',
        ]);

        $commande->update($request->all());

        return redirect()->route('commandes.index')
            ->with('success', 'Commande mise à jour avec succès !');
    }

    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();

        return redirect()->route('commandes.index')
            ->with('success', 'Commande supprimée avec succès !');
    }
}
