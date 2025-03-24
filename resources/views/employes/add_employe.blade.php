<!-- resources/views/employes/create.blade.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Enregistrement | ERP</title>
</head>

<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Se déconnecter</button>
        </form>
        <div class="flex flex-col md:flex-row w-full max-w-4xl mx-auto p-6 gap-6">
            <!-- Formulaire avec taille réduite -->
            <form action="/add_employe" method="POST"
                class="w-full md:w-1/2 p-6 bg-white rounded-lg shadow-md animate-fade-in h-fit">
                @csrf
                @if(session('success'))
                    <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Champ Nom -->
                <div class="mb-4 animate-slide-up" style="animation-delay: 0.1s;">
                    <input type="text" name="nom" id="nom" placeholder="Nom"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                        value="{{ old('nom') }}">
                    @if ($errors->has('nom'))
                        <div class="text-red-500 text-sm">{{ $errors->first('nom') }}</div>
                    @endif
                </div>

                <!-- Champ Prénom -->
                <div class="mb-4 animate-slide-up" style="animation-delay: 0.2s;">
                    <input type="text" name="prenom" id="prenom" placeholder="Prénom"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                        value="{{ old('prenom') }}">
                    @if ($errors->has('prenom'))
                        <div class="text-red-500 text-sm">{{ $errors->first('prenom') }}</div>
                    @endif
                </div>

                <!-- Champ Email -->
                <div class="mb-4 animate-slide-up" style="animation-delay: 0.3s;">
                    <input type="email" name="email" id="email" placeholder="Email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                        value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- Champ Téléphone -->
                <div class="mb-4 animate-slide-up" style="animation-delay: 0.4s;">
                    <input type="text" name="telephone" id="telephone" placeholder="Téléphone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                        value="{{ old('telephone') }}">
                    @if ($errors->has('telephone'))
                        <div class="text-red-500 text-sm mt-1">{{ $errors->first('telephone') }}</div>
                    @endif
                </div>

                <!-- Champ Date d'embauche -->
                <div class="mb-4 animate-slide-up" style="animation-delay: 0.5s;">
                    <input type="date" name="date_embauche" id="date_embauche"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                        value="{{ old('date_embauche') }}">
                    @if ($errors->has('date_embauche'))
                        <div class="text-red-500 text-sm">{{ $errors->first('date_embauche') }}</div>
                    @endif
                </div>

                <!-- Champ Département -->
                <div class="mb-6 animate-slide-up" style="animation-delay: 0.6s;">
                    <select name="departement"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus bg-white">
                        <option value="" disabled selected>Sélectionner un département</option>
                        <option value="rh" {{ old('departement') == 'rh' ? 'selected' : '' }}>RH</option>
                        <option value="finance" {{ old('departement') == 'finance' ? 'selected' : '' }}>Finance</option>
                        <option value="informatique" {{ old('departement') == 'informatique' ? 'selected' : '' }}>
                            Informatique</option>
                        <option value="livraison" {{ old('departement') == 'livraison' ? 'selected' : '' }}>Livraison
                        </option>
                    </select>
                    @if ($errors->has('departement'))
                        <div class="text-red-500 text-sm">{{ $errors->first('departement') }}</div>
                    @endif
                </div>
                <!-- Bouton d'envoi -->
                <div class="animate-slide-up" style="animation-delay: 0.7s;">
                    <button type="submit"
                        class="w-full bg-[#38d62c] hover:bg-[#87e8b6] text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out button-hover">
                        Enregistrer
                    </button>
                </div>
            </form>

            <!-- Liste des employés avec recherche et tri -->
            <div class="w-full md:w-1/2 p-6 bg-white rounded-lg shadow-md animate-fade-in">
                <h2 class="text-xl font-semibold mb-4">Liste des employés</h2>

                <!-- Barre de recherche -->
                <div class="mb-4">
                    <input type="text" id="searchInput" placeholder="Rechercher par nom..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>

                <!-- Options de tri -->
                <div class="mb-4 flex flex-col sm:flex-row gap-2">
                    <select id="sortSelect"
                        class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        <option value="">Trier par...</option>
                        <option value="nom_asc">Nom (A-Z)</option>
                        <option value="nom_desc">Nom (Z-A)</option>
                        <option value="departement_asc">Département (A-Z)</option>
                        <option value="departement_desc">Département (Z-A)</option>
                        <option value="id_asc">ID (Croissant)</option>
                        <option value="id_desc">ID (Décroissant)</option>
                    </select>
                </div>

                <!-- Liste des employés -->
                <div class="max-h-96 overflow-y-auto">
                    @if($employes->isEmpty())
                        <p class="text-gray-500">Aucun employé enregistré.</p>
                    @else
                        <ul id="employeeList" class="space-y-2">
                            @foreach($employes as $employe)
                                <li class="employee-item p-3 bg-gray-50 rounded-md hover:bg-gray-100 transition"
                                    data-nom="{{ $employe->nom }}" data-departement="{{ $employe->departement }}"
                                    data-id="{{ $employe->id_employe }}">
                                    <span class="font-medium">{{ $employe->nom }} {{ $employe->prenom }}</span>
                                    <span class="text-gray-600"> - {{ $employe->email }}</span>
                                    <span class="text-sm text-gray-500">({{ $employe->departement }})</span>
                                    <span class="text-sm text-gray-500">(ID: {{ $employe->id_employe }})</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mise à jour automatique de l'email
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

        // Fonction de recherche
        document.getElementById('searchInput').addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const employees = document.getElementsByClassName('employee-item');

            Array.from(employees).forEach(employee => {
                const nom = employee.getAttribute('data-nom').toLowerCase();
                if (nom.includes(searchTerm)) {
                    employee.style.display = 'block';
                } else {
                    employee.style.display = 'none';
                }
            });
        });

        // Fonction de tri
        document.getElementById('sortSelect').addEventListener('change', function (e) {
            const sortValue = e.target.value;
            const employeeList = document.getElementById('employeeList');
            const employees = Array.from(employeeList.getElementsByClassName('employee-item'));

            employees.sort((a, b) => {
                if (sortValue === 'nom_asc') {
                    return a.getAttribute('data-nom').localeCompare(b.getAttribute('data-nom'));
                } else if (sortValue === 'nom_desc') {
                    return b.getAttribute('data-nom').localeCompare(a.getAttribute('data-nom'));
                } else if (sortValue === 'departement_asc') {
                    return a.getAttribute('data-departement').localeCompare(b.getAttribute('data-departement'));
                } else if (sortValue === 'departement_desc') {
                    return b.getAttribute('data-departement').localeCompare(a.getAttribute('data-departement'));
                } else if (sortValue === 'id_asc') {
                    return a.getAttribute('data-id') - b.getAttribute('data-id');
                } else if (sortValue === 'id_desc') {
                    return b.getAttribute('data-id') - a.getAttribute('data-id');
                }
                return 0;
            });

            // Réorganiser les éléments dans la liste
            employees.forEach(employee => {
                employeeList.appendChild(employee);
            });
        });
    </script>
</body>

</html>