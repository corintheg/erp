<?php

namespace App\Http\Controllers;

use App\Models\Salaire;
use Illuminate\Http\Request;

class SalaireController extends Controller
{
    public function index()
    {
        $salaires = Salaire::with('employe')->get();
        return response()->json($salaires);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_employe' => 'required|exists:employes,id_employe',
            'montant' => 'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date'
        ]);

        $salaire = Salaire::create($request->only(['id_employe','montant','date_debut','date_fin']));
        return response()->json(['message' => 'Salaire ajouté avec succès', 'salaire' => $salaire], 201);
    }

    public function show($id)
    {
        $salaire = Salaire::with('employe')->findOrFail($id);
        return response()->json($salaire);
    }

    public function update(Request $request, $id)
    {
        $salaire = Salaire::findOrFail($id);
        $request->validate([
            'montant' => 'numeric',
            'date_debut' => 'date',
            'date_fin' => 'nullable|date'
        ]);
        $salaire->update($request->only(['montant','date_debut','date_fin']));
        return response()->json(['message' => 'Salaire mis à jour', 'salaire' => $salaire]);
    }

    public function destroy($id)
    {
        $salaire = Salaire::findOrFail($id);
        $salaire->delete();
        return response()->json(['message' => 'Salaire supprimé']);
    }
}
