<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index()
    {
        // Récupère tous les fournisseurs
        $fournisseurs = Fournisseur::all();

        // Retourne la vue 'fournisseurs.index' avec la liste des fournisseurs
        return view('fournisseurs.index', compact('fournisseurs'));
    }
    private function formatSiteWeb($url)
    {
        if (!empty($url) && !preg_match('/^https?:\/\//i', $url)) {
            return 'https://' . $url;
        }
        return $url;
    }

    public function create()
    {
        return view('fournisseurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'contact' => 'nullable|string|max:100',
            'email' => 'required|email|max:100',
            'telephone' => 'nullable|string|max:50',
            'adresse' => 'nullable|string',
            'site_web' => 'nullable|string|max:150',
        ]);

        $data = $request->all();
        $data['site_web'] = $this->formatSiteWeb($data['site_web']);


        Fournisseur::create($data);

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur créé avec succès !');
    }

    public function edit($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'contact' => 'nullable|string|max:100',
            'email' => 'required|email|max:100',
            'telephone' => 'nullable|string|max:50',
            'adresse' => 'nullable|string',
            'site_web' => 'nullable|string|max:150',
        ]);

        $data = $request->all();
        $data['site_web'] = $this->formatSiteWeb($data['site_web']);

        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->update($data);

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Fournisseur supprimé avec succès !');
    }
}