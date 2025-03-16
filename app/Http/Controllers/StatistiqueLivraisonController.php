<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livraison;

class StatistiqueLivraisonController extends Controller
{
    public function index()
    {
        $totalLivraisons = Livraison::count();
        $livraisonsEffectuees = Livraison::where('status', 'livré')->count();
        $livraisonsEnCours = Livraison::where('status', 'en cours')->count();

        return response()->json([
            'total_livraisons' => $totalLivraisons,
            'effectuees' => $livraisonsEffectuees,
            'en_cours' => $livraisonsEnCours,
        ]);
    }
}
