<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fournisseur;

class StatistiqueFournisseurController extends Controller
{
    public function index()
    {
        $totalFournisseurs = Fournisseur::count();
        $actifs = Fournisseur::where('statut', 'actif')->count();
        $inactifs = Fournisseur::where('statut', 'inactif')->count();

        return response()->json([
            'total_fournisseurs' => $totalFournisseurs,
            'actifs' => $actifs,
            'inactifs' => $inactifs,
        ]);
    }
}
