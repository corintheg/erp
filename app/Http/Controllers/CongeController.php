<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use Illuminate\Http\Request;

class CongeController extends Controller
{
//    public function index()
//    {
//        $conges = Conge::with('employe')->get();
//        return response()->json($conges);
//    }
//    public function store(Request $request)
//    {
//        $request->validate([
//            'id_employe' => 'required|exists:employes,id_employe',
//            'type_conge' => 'required|in:RTT,CP,Maladie',
//            'date_debut' => 'required|date',
//            'date_fin' => 'required|date|after_or_equal:date_debut'
//        ]);
//
//        $conge = Conge::create($request->only(['id_employe','type_conge','date_debut','date_fin']));
//        return response()->json(['message' => 'Congé créé avec succès', 'conge' => $conge], 201);
//    }
//    public function show($id)
//    {
//        $conge = Conge::with('employe')->findOrFail($id);
//        return response()->json($conge);
//    }
//    public function update(Request $request, $id)
//    {
//        $conge = Conge::findOrFail($id);
//        $request->validate([
//            'statut' => 'required|in:En attente,Validé,Annulé',
//            'commentaires' => 'nullable|string'
//        ]);
//        $conge->update($request->only(['statut','commentaires']));
//        return response()->json(['message' => 'Congé mis à jour', 'conge' => $conge]);
//    }
//    public function destroy($id)
//    {
//        $conge = Conge::findOrFail($id);
//        $conge->delete();
//        return response()->json(['message' => 'Congé supprimé']);
//    }

    public function view_leave_request(){
            return view('leave_request');
        }
    public function leave_request(Request $request)
    {

        $conge = new Conge();
        $conge->id_employe = $request->user_id ;
        $conge->type_conge = $request->type_conge;
        $conge->date_debut = $request->date_debut;
        $conge->commentaires =$request->raison;
        $conge->date_fin = $request->date_fin;
        $conge->save();
        return response()->json(['message' => 'Employé enregistré avec succès !']);
    }

}
