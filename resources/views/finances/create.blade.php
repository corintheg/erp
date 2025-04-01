@extends('layouts.app')

@section('content')
<main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
    <header class="bg-white shadow p-4 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold">Nouvelle entrée financière</h2>
    </header>

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

    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <form action="{{ route('finances.store') }}" method="POST">
            @csrf

            <!-- type_operation -->
            <div class="mb-4">
                <label for="type_operation" class="block text-gray-700 font-medium mb-2">Type d'opération</label>
                <select id="type_operation" name="type_operation" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    <option value="">-- Sélectionnez un type --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}"
                            {{ old('type_operation') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">{{ old('description') }}</textarea>
            </div>

            <!-- montant -->
            <div class="mb-4">
                <label for="montant" class="block text-gray-700 font-medium mb-2">Montant</label>
                <input type="number" step="0.01" id="montant" name="montant" value="{{ old('montant') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>

            <!-- date_operation -->
            <div class="mb-4">
                <label for="date_operation" class="block text-gray-700 font-medium mb-2">Date d'opération</label>
                <input type="date" id="date_operation" name="date_operation"
                    value="{{ old('date_operation') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>

            <!-- categorie -->
            <div class="mb-4">
                <label for="categorie" class="block text-gray-700 font-medium mb-2">Catégorie</label>
                <select id="categorie" name="categorie" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    <option value="">-- Sélectionnez une catégorie --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}"
                            {{ old('categorie') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- id_fournisseur -->
            <div class="mb-4">
                <label for="id_fournisseur" class="block text-gray-700 font-medium mb-2">Fournisseur (optionnel)</label>
                <select id="id_fournisseur" name="id_fournisseur"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    <option value="">-- Aucun --</option>
                    @foreach ($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id_fournisseur }}"
                            {{ old('id_fournisseur') == $fournisseur->id_fournisseur ? 'selected' : '' }}>
                            {{ $fournisseur->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- statut -->
            <div class="mb-4">
                <label for="statut" class="block text-gray-700 font-medium mb-2">Statut</label>
                <select id="statut" name="statut" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    <option value="">-- Sélectionnez un statut --</option>
                    @foreach ($statuts as $stat)
                        <option value="{{ $stat }}"
                            {{ old('statut') == $stat ? 'selected' : '' }}>
                            {{ $stat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- ref_facture -->
            <div class="mb-6">
                <label for="reference_facture" class="block text-gray-700 font-medium mb-2">Réf. Facture (optionnel)</label>
                <input type="text" id="reference_facture" name="reference_facture" value="{{ old('reference_facture') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
                <a href="{{ route('finances.index') }}"
                    class="w-full sm:w-auto text-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                    Annuler
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</main>
@endsection