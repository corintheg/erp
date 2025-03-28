@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <!-- Header de la page -->
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">Modification du salaire</h2>
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
            <form action="{{ route('salaires.update', $salaire->id_salaire) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="id_employe" class="block text-gray-700 font-medium mb-2">
                        Employé
                    </label>
                    <select id="id_employe" name="id_employe"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]"
                        required>
                        @foreach ($employes as $employe)
                            <option value="{{ $employe->id_employe }}" {{ $salaire->id_employe == $employe->id_employe ? 'selected' : '' }}>
                                {{ $employe->nom }} {{ $employe->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_employe')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="montant" class="block text-gray-700 font-medium mb-2">
                        Montant (€)
                    </label>
                    <input type="number" step="0.01" id="montant" name="montant"
                        value="{{ old('montant', $salaire->montant) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]"
                        required>
                    @error('montant')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="date_debut" class="block text-gray-700 font-medium mb-2">
                        Date de Début
                    </label>
                    <input type="date" id="date_debut" name="date_debut"
                        value="{{ old('date_debut', $salaire->date_debut) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]"
                        required>
                    @error('date_debut')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="date_fin" class="block text-gray-700 font-medium mb-2">
                        Date de Fin (optionnel)
                    </label>
                    <input type="date" id="date_fin" name="date_fin" value="{{ old('date_fin', $salaire->date_fin) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('date_fin')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('salaires.index') }}"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        Mettre à jour le salaire
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection