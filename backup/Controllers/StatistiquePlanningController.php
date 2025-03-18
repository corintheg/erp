<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planning;

class StatistiquePlanningController extends Controller
{
    public function index()
    {
        $totalPlannings = Planning::count();
        $planningsEffectues = Planning::where('status', 'termine')->count();
        $planningsEnCours = Planning::where('status', 'en cours')->count();

        return response()->json([
            'total_plannings' => $totalPlannings,
            'effectues' => $planningsEffectues,
            'en_cours' => $planningsEnCours,
        ]);
    }
}
