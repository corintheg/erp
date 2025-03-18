<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::with('employe')->get();
        return response()->json($absences);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_employe' => 'required|exists:employes,id_employe',
            'date_absence' => 'required|date',
            'motif' => 'nullable|string'
        ]);

        $absence = Absence::create($request->only(['id_employe','date_absence','motif']));
        return response()->json(['message' => 'Absence enregistrée', 'absence' => $absence], 201);
    }

    public function show($id)
    {
        $absence = Absence::with('employe')->findOrFail($id);
        return response()->json($absence);
    }

    public function update(Request $request, $id)
    {
        $absence = Absence::findOrFail($id);
        $request->validate([
            'date_absence' => 'date',
            'motif' => 'nullable|string'
        ]);
        $absence->update($request->only(['date_absence','motif']));
        return response()->json(['message' => 'Absence mise à jour', 'absence' => $absence]);
    }

    public function destroy($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();
        return response()->json(['message' => 'Absence supprimée']);
    }
}
