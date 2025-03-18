<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use Illuminate\Http\Request;

class CongeController extends Controller
{
    public function index()
    {
        $conges = Conge::with('employe')->get();
        return response()->json($conges);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_employe' => 'required|exists:employes,id_employe',
            'type_conge' => 'required|in:RTT,CP,Maladie',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut'
        ]);

        $conge = Conge::create($request->only(['id_employe','type_conge','date_debut','date_fin']));
        return response()->json(['message' => 'Congé créé avec succès', 'conge' => $conge], 201);
    }

    public function show($id)
    {
        $conge = Conge::with('employe')->findOrFail($id);
        return response()->json($conge);
    }

    public function update(Request $request, $id)
    {
        $conge = Conge::findOrFail($id);
        $request->validate([
            'statut' => 'required|in:En attente,Validé,Annulé',
            'commentaires' => 'nullable|string'
        ]);
        $conge->update($request->only(['statut','commentaires']));
        return response()->json(['message' => 'Congé mis à jour', 'conge' => $conge]);
    }

    public function destroy($id)
    {
        $conge = Conge::findOrFail($id);
        $conge->delete();
        return response()->json(['message' => 'Congé supprimé']);
    }
}
