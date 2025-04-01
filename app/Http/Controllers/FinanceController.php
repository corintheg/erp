<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::all();

        return view('finances.index', compact('finances'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::all();

        $types = ['dépense', 'revenu', 'facture', 'taxe'];
        $categories = ['Marketing', 'Salaire', 'Fournisseur'];
        $statuts = ['Payé', 'En attente', 'Annulé'];

        return view('finances.create', compact('fournisseurs', 'types', 'categories', 'statuts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type_operation' => 'required|in:dépense,revenu,facture,taxe',
            'description' => 'nullable|string',
            'montant' => 'required|numeric',
            'date_operation' => 'required|date',
            'categorie' => 'required|in:Marketing,Salaire,Fournisseur',
            'id_fournisseur' => 'nullable|integer',
            'statut' => 'required|in:Payé,En attente,Annulé',
            'reference_facture' => 'nullable|string',
        ]);


        Finance::create($data);

        return redirect()->route('finances.index')
            ->with('success', 'Enregistrement financier créé avec succès !');
    }

    public function edit($id)
    {
        $finance = Finance::findOrFail($id);
        $fournisseurs = Fournisseur::all();

        $types = ['dépense', 'revenu', 'facture', 'taxe'];
        $categories = ['Marketing', 'Salaire', 'Fournisseur'];
        $statuts = ['Payé', 'En attente', 'Annulé'];

        return view('finances.edit', compact('finance', 'fournisseurs', 'types', 'categories', 'statuts'));
    }

    public function update(Request $request, $id)
    {
        $finance = Finance::findOrFail($id);

        $data = $request->validate([
            'type_operation' => 'required|in:dépense,revenu,facture,taxe',
            'description' => 'nullable|string',
            'montant' => 'required|numeric',
            'date_operation' => 'required|date',
            'categorie' => 'required|in:Marketing,Salaire,Fournisseur',
            'id_fournisseur' => 'nullable|integer',
            'statut' => 'required|in:Payé,En attente,Annulé',
            'reference_facture' => 'nullable|string',
        ]);

        $finance->update($data);

        return redirect()->route('finances.index')
            ->with('success', 'Enregistrement financier mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $finance = Finance::findOrFail($id);
        $finance->delete();

        return redirect()->route('finances.index')
            ->with('success', 'Enregistrement financier supprimé avec succès !');
    }
}
