<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;

class StatistiqueRhController extends Controller
{
    public function index()
    {
        $congesDemandes = Conge::count();
        $congesApprouves = Conge::where('statut', 'approuve')->count();
        $congesRefuses = Conge::where('statut', 'refuse')->count();

        return response()->json([
            'conges_demandes' => $congesDemandes,
            'conges_approuves' => $congesApprouves,
            'conges_refuses' => $congesRefuses,
        ]);
    }
}
