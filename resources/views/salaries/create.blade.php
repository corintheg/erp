@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">


        <form action="{{ route('salaries.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow w-[80%] absolute right-0 mr-6">
            @csrf

            <h2 class="text-2xl font-semibold mb-4">Ajouter un Nouveau Salaire</h2>

            <div class="mb-4">
                <label for="id_employe" class="block text-sm font-medium text-gray-700">Employé</label>
                <select name="id_employe" id="id_employe" class="w-full border border-gray-300 rounded p-2" required>
                    @foreach($employes as $employe)
                        <option value=>{{ $employe->nom }} {{ $employe->prenom }}</option>
                    @endforeach
                </select>
                @error('id_employe')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="montant" class="block text-sm font-medium text-gray-700">Montant</label>
                <input type="number" name="montant" id="montant" class="w-full border border-gray-300 rounded p-2" required value="{{ old('montant') }}">
                @error('montant')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" class="w-full border border-gray-300 rounded p-2" required value="{{ old('date_debut') }}">
                @error('date_debut')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin</label>
                <input type="date" name="date_fin" id="date_fin" class="w-full border border-gray-300 rounded p-2" value="{{ old('date_fin') }}">
                @error('date_fin')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Ajouter le Salaire</button>
            </div>
        </form>
    </div>
@endsection

<style>

    .container {
        position: relative;
        min-height: 100vh;
    }
</style>