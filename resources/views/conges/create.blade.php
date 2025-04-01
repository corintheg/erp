@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <!-- Header -->
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">Nouvelle demande de congé</h2>
        </header>

        <!-- Erreurs -->
        @if ($errors->any())
            <div class="mb-4 p-2 bg-red-100 text-red-700 rounded-md">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Succès -->
        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <form action="{{ route('conges.create.store') }}" method="POST">
                @csrf

                <!-- ID utilisateur caché -->
                <input type="hidden" name="user_id" value="{{ Auth::user()->id_employe }}">

                <!-- Type -->
                <div class="mb-4">
                    <label for="type_conge" class="block text-gray-700 font-medium mb-2">Type de congé</label>
                    <select id="type_conge" name="type_conge" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        <option value="">Sélectionnez un type</option>
                        <option value="RTT" {{ old('type_conge') == 'RTT' ? 'selected' : '' }}>RTT</option>
                        <option value="CP" {{ old('type_conge') == 'CP' ? 'selected' : '' }}>Congés Payés (CP)</option>
                        <option value="Maladie" {{ old('type_conge') == 'Maladie' ? 'selected' : '' }}>Maladie</option>
                    </select>
                </div>

                <!-- Dates -->
                <div class="mb-4">
                    <label for="date_debut" class="block text-gray-700 font-medium mb-2">Date de début</label>
                    <input type="date" id="date_debut" name="date_debut" value="{{ old('date_debut') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>
                <div class="mb-4">
                    <label for="date_fin" class="block text-gray-700 font-medium mb-2">Date de fin</label>
                    <input type="date" id="date_fin" name="date_fin" value="{{ old('date_fin') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <!-- Raison -->
                <div class="mb-4">
                    <label for="raison" class="block text-gray-700 font-medium mb-2">Raison</label>
                    <textarea id="raison" name="raison" rows="3" placeholder="Expliquez la raison de votre demande"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">{{ old('raison') }}</textarea>
                </div>

                <!-- Boutons -->
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-6">
                    @if (Auth::user()->hasRole('superadmin'))
                        <a href="{{ route('conges.index') }}"
                            class="w-full sm:w-auto text-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                            Annuler
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}"
                            class="w-full sm:w-auto text-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                            Annuler
                        </a>
                    @endif


                    <button type="submit" id="submitButton"
                        class="w-full sm:w-auto px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        Soumettre la demande
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const typeCongeSelect = document.getElementById('type_conge');
        const submitButton = document.getElementById('submitButton');

        typeCongeSelect.addEventListener('change', function () {
            submitButton.textContent = this.value === 'Maladie'
                ? 'Envoyer le congé'
                : 'Soumettre la demande';
        });
    </script>
@endsection