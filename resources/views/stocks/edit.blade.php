@extends('layouts.app')

@section('content')
<main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
    <!-- Header -->
    <header class="bg-white shadow p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">Modification du produit</h2>
    </header>

    <!-- Alertes -->
    @if (session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-2 bg-red-100 text-red-700 rounded-md">
            <ul class="list-disc pl-4 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <form action="{{ route('stocks.update', $stock->id_produit) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nom du produit -->
            <div class="mb-4">
                <label for="nom_produit" class="block text-gray-700 font-medium mb-2">Nom du produit</label>
                <input type="text" id="nom_produit" name="nom_produit"
                    value="{{ old('nom_produit', $stock->nom_produit) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>

            <!-- Fournisseur -->
            <div class="mb-4">
                <label for="id_fournisseur" class="block text-gray-700 font-medium mb-2">Fournisseur</label>
                <select id="id_fournisseur" name="id_fournisseur"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    <option value="">-- Sélectionnez un fournisseur --</option>
                    @foreach ($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id_fournisseur }}"
                            {{ old('id_fournisseur', $stock->id_fournisseur) == $fournisseur->id_fournisseur ? 'selected' : '' }}>
                            {{ $fournisseur->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Quantité -->
            <div class="mb-4">
                <label for="quantite" class="block text-gray-700 font-medium mb-2">Quantité</label>
                <input type="number" id="quantite" name="quantite"
                    value="{{ old('quantite', $stock->quantite) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">{{ old('description', $stock->description) }}</textarea>
            </div>

            <!-- Seuil d'alerte -->
            <div class="mb-4">
                <label for="seuil_alerte" class="block text-gray-700 font-medium mb-2">Seuil d'alerte</label>
                <input type="number" id="seuil_alerte" name="seuil_alerte"
                    value="{{ old('seuil_alerte', $stock->seuil_alerte) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>

            <!-- Prix d'achat -->
            <div class="mb-4">
                <label for="prix_achat" class="block text-gray-700 font-medium mb-2">Prix d'achat</label>
                <input type="number" step="0.01" id="prix_achat" name="prix_achat"
                    value="{{ old('prix_achat', $stock->prix_achat) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>

            <!-- Prix de vente -->
            <div class="mb-4">
                <label for="prix_vente" class="block text-gray-700 font-medium mb-2">Prix de vente</label>
                <input type="number" step="0.01" id="prix_vente" name="prix_vente"
                    value="{{ old('prix_vente', $stock->prix_vente) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>

            <!-- Boutons -->
            <div class="flex flex-col sm:flex-row justify-between gap-2">
                <a href="{{ route('stocks.index') }}"
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 text-center">
                    Annuler
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                    Mettre à jour le produit
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
