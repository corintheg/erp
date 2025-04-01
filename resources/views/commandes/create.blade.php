@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <!-- Header -->
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">Enregistrement d’une nouvelle commande</h2>
        </header>

        <!-- Messages -->
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
            <form action="{{ route('commandes.store') }}" method="POST">
                @csrf

                <!-- Référence -->
                <div class="mb-4">
                    <label for="reference_commande" class="block text-gray-700 font-medium mb-2">
                        Référence de la commande
                    </label>
                    <input type="text" id="reference_commande" name="reference_commande"
                        value="{{ old('reference_commande') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <!-- Fournisseur -->
                <div class="mb-4">
                    <label for="id_fournisseur" class="block text-gray-700 font-medium mb-2">
                        Fournisseur
                    </label>
                    <select id="id_fournisseur" name="id_fournisseur"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        <option value="">-- Aucun --</option>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id_fournisseur }}"
                            {{ old('id_fournisseur') == $fournisseur->id_fournisseur ? 'selected' : '' }}>
                            {{ $fournisseur->nom }} </option>
                        @endforeach
                    </select>
                </div>

                <!-- Destinataire -->
                <div class="mb-4">
                    <label for="destinataire" class="block text-gray-700 font-medium mb-2">
                        Destinataire
                    </label>
                    <input type="text" id="destinataire" name="destinataire" value="{{ old('destinataire') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <!-- Date de livraison -->
                <div class="mb-4">
                    <label for="date_livraison" class="block text-gray-700 font-medium mb-2">
                        Date de livraison
                    </label>
                    <input type="date" id="date_livraison" name="date_livraison"
                        value="{{ old('date_livraison') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <!-- Statut -->
                <div class="mb-4">
                    <label for="statut_livraison" class="block text-gray-700 font-medium mb-2">
                        Statut de la livraison
                    </label>
                    <select id="statut_livraison" name="statut_livraison" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        <option value="">-- Sélectionnez un statut --</option>
                        @foreach ($statuts as $statut)
                            <option value="{{ $statut }}" {{ old('statut_livraison') == $statut ? 'selected' : '' }}>
                                {{ $statut }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Boutons -->
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-6">
                    <a href="{{ route('commandes.index') }}"
                        class="w-full sm:w-auto text-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        Enregistrer la commande
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
