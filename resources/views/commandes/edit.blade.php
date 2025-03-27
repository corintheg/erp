@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <!-- Header de la page -->
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">Modification d’une commande</h2>
        </header>

        <!-- Messages de succès et d'erreur -->
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

        <!-- Formulaire de modification -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('commandes.update', $commande->id_livraison) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Référence de la commande -->
                <div class="mb-4">
                    <label for="reference_commande" class="block text-gray-700 font-medium mb-2">
                        Référence de la commande
                    </label>
                    <input type="text" id="reference_commande" name="reference_commande"
                        value="{{ old('reference_commande', $commande->reference_commande) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <!-- Fournisseur (menu déroulant) -->
                <div class="mb-4">
                    <label for="id_fournisseur" class="block text-gray-700 font-medium mb-2">
                        Fournisseur
                    </label>
                    <select id="id_fournisseur" name="id_fournisseur"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        <option value="">-- Aucun --</option>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id_fournisseur }}"
                                {{ old('id_fournisseur', $commande->id_fournisseur) == $fournisseur->id_fournisseur ? 'selected' : '' }}>
                                {{ $fournisseur->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Statut (menu déroulant) -->
                <div class="mb-4">
                    <label for="statut_livraison" class="block text-gray-700 font-medium mb-2">
                        Statut de la livraison
                    </label>
                    <select id="statut_livraison" name="statut_livraison" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        <option value="">-- Sélectionnez un statut --</option>
                        @foreach ($statuts as $statut)
                            <option value="{{ $statut }}"
                                {{ old('statut_livraison', $commande->statut_livraison) == $statut ? 'selected' : '' }}>
                                {{ $statut }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('commandes.index') }}"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        Mettre à jour la commande
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
