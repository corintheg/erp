@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <!-- Header -->
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">Enregistrement d’un nouveau salaire</h2>
        </header>

        <!-- Messages -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                <ul class="list-disc pl-4 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <form action="{{ route('salaires.store') }}" method="POST">
                @csrf

                <!-- Employé -->
                <div class="mb-4">
                    <label for="id_employe" class="block text-gray-700 font-medium mb-2">Employé</label>
                    <select name="id_employe" id="id_employe" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        @foreach ($employes as $employe)
                            <option value="{{ $employe->id_employe }}">
                                {{ $employe->nom }} {{ $employe->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_employe')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Montant -->
                <div class="mb-4">
                    <label for="montant" class="block text-gray-700 font-medium mb-2">Montant (€)</label>
                    <input type="number" step="0.01" name="montant" id="montant" value="{{ old('montant') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('montant')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Date de début -->
                <div class="mb-4">
                    <label for="date_debut" class="block text-gray-700 font-medium mb-2">Date de début</label>
                    <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('date_debut')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div class="mb-4">
                    <label for="date_fin" class="block text-gray-700 font-medium mb-2">Date de fin (optionnel)</label>
                    <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    @error('date_fin')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row justify-between items-stretch gap-3 mt-6">
                    <a href="{{ route('salaires.index') }}"
                        class="w-full sm:w-auto text-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        Enregistrer le salaire
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection