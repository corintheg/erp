<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;

{
class StatistiqueEmployeController extends Controller
    public function index()
    {
        $totalEmployes = Employe::count();
        $actifs = Employe::where('status', 'actif')->count();
        $inactifs = Employe::where('status', 'inactif')->count();

        return response()->json([
            'total' => $totalEmployes,
            'actifs' => $actifs,
            'inactifs' => $inactifs,
        ]);
    }
}
