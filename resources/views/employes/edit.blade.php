@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <!-- Header de la page -->
        <header class="bg-white shadow p-4 rounded-lg mb-6">
            <h2 class="text-2xl font-semibold">Modification de l'employé</h2>
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
            <form action="{{ route('employes.update', $employe->id_employe) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nom" class="block text-gray-700 font-medium mb-2">
                        Nom
                    </label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $employe->nom) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="prenom" class="block text-gray-700 font-medium mb-2">
                        Prénom
                    </label>
                    <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $employe->prenom) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">
                        Adresse Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $employe->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="telephone" class="block text-gray-700 font-medium mb-2">
                        Téléphone
                    </label>
                    <input type="text" id="telephone" name="telephone" value="{{ old('telephone', $employe->telephone) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-4">
                    <label for="date_embauche" class="block text-gray-700 font-medium mb-2">
                        Date d'embauche
                    </label>
                    <input type="date" id="date_embauche" name="date_embauche"
                        value="{{ old('date_embauche', $employe->date_embauche) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="mb-6">
                    <label for="departement" class="block text-gray-700 font-medium mb-2">
                        Département
                    </label>
                    <select name="departement"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] bg-white">
                        <option value="" disabled>Sélectionner un département</option>
                        <option value="rh" {{ strtolower(old('departement', $employe->departement)) == 'rh' ? 'selected' : '' }}>RH</option>
                        <option value="finance" {{ strtolower(old('departement', $employe->departement)) == 'finance' ? 'selected' : '' }}>Finance</option>
                        <option value="informatique" {{ strtolower(old('departement', $employe->departement)) == 'informatique' ? 'selected' : '' }}>Informatique</option>
                        <option value="livraison" {{ strtolower(old('departement', $employe->departement)) == 'livraison' ? 'selected' : '' }}>Livraison</option>
                        <option value="employe" {{ strtolower(old('departement', $employe->departement)) == 'employe' ? 'selected' : '' }}>Employé</option>
                    </select>
                </div>

                <!-- Champ Actif -->
                <div class="mb-6">
                    <label for="actif" class="block text-gray-700 font-medium mb-2">Employé actif ?</label>
                    <select name="actif" id="actif"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        <option value="1" {{ old('actif', $employe->actif) == 1 ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ old('actif', $employe->actif) == 0 ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <!-- Champ Date de débauche affiché pour permettre la modification -->
                <div class="mb-6">
                    <label for="date_debauche" class="block text-gray-700 font-medium mb-2">
                        Date de débauche
                    </label>
                    <input type="date" name="date_debauche" id="date_debauche"
                        value="{{ old('date_debauche', $employe->date_debauche) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('employes.index') }}"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                        Annuler
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Mise à jour automatique de l'email en fonction des champs nom et prénom
        document.getElementById('nom').addEventListener('input', updateEmail);
        document.getElementById('prenom').addEventListener('input', updateEmail);

        function updateEmail() {
            const nom = document.getElementById('nom').value;
            const prenom = document.getElementById('prenom').value;
            const emailField = document.getElementById('email');
            if (nom && prenom) {
                const email = `${nom.toLowerCase()}.${prenom.toLowerCase()}@erp.com`;
                emailField.value = email;
            }
        }

        // Gestion de l'état actif/inactif avec mise à jour du champ Date de débauche
        document.getElementById('actif').addEventListener('change', function () {
            var actif = this.value;
            var dateDebaucheInput = document.getElementById('date_debauche');
            if (actif === '0') {
                // Si inactif, définir la date de débauche à la date du jour (format YYYY-MM-DD)
                var today = new Date().toISOString().split('T')[0];
                dateDebaucheInput.value = today;
            } else {
                // Si actif, vider la date de débauche
                dateDebaucheInput.value = "";
            }
        });
    </script>
@endsection