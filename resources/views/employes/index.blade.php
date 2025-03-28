@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <!-- Header de la page -->
        <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Gestion des Employés</h2>
            <a href="{{ route('employes.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouvel employé
            </a>
        </header>

        <!-- Message de succès -->
        @if (session('error'))
            <div class="flex items-center gap-3 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow mb-4">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <span class="text-base">{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow mb-4">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="text-base">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tableau des employés -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-4 flex flex-col sm:flex-row gap-4">
                <input type="text" id="searchInput" placeholder="Rechercher par nom, prénom, email, département..."
                    class="w-full sm:w-1/2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                <!-- Filtre Actif -->
                <select id="activeFilter"
                    class="w-full sm:w-1/4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    <option value="all">Tous</option>
                    <option value="yes">Actif : Oui</option>
                    <option value="no">Actif : Non</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-gray-700">Nom</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Prénom</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Email</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Département</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Date d'embauche</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Date de débauche</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Actif</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employeeList">
                        @forelse ($employes as $employe)
                            <tr class="border-b hover:bg-gray-50 employee-item" data-nom="{{ strtolower($employe->nom) }}"
                                data-prenom="{{ strtolower($employe->prenom) }}" data-email="{{ strtolower($employe->email) }}"
                                data-departement="{{ strtolower($employe->departement) }}"
                                data-actif="{{ $employe->actif ? 'yes' : 'no' }}">
                                <td class="px-4 py-3">{{ $employe->nom }}</td>
                                <td class="px-4 py-3">{{ $employe->prenom }}</td>
                                <td class="px-4 py-3">{{ $employe->email }}</td>
                                <td class="px-4 py-3">{{ $employe->departement }}</td>
                                <td class="px-4 py-3">{{ $employe->date_embauche }}</td>
                                <td class="px-4 py-3">{{ $employe->date_debauche ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $employe->actif ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                                        {{ $employe->actif ? 'Oui' : 'Non' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('employes.edit', $employe->id_employe) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                        Modifier
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">
                                    Aucun employé trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            // Fonction pour filtrer les employés
            function filterEmployees() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const activeFilter = document.getElementById('activeFilter').value;
                const employees = document.querySelectorAll('.employee-item');

                employees.forEach(employee => {
                    const nom = employee.getAttribute('data-nom');
                    const prenom = employee.getAttribute('data-prenom');
                    const email = employee.getAttribute('data-email');
                    const departement = employee.getAttribute('data-departement');
                    const actif = employee.getAttribute('data-actif');

                    // Vérifier si l'employé correspond au terme de recherche
                    const matchesSearch = nom.includes(searchTerm) || prenom.includes(searchTerm) || email.includes(searchTerm) || departement.includes(searchTerm);

                    // Vérifier si l'employé correspond au filtre actif
                    const matchesActive = activeFilter === 'all' || actif === activeFilter;

                    // Afficher ou masquer l'employé
                    if (matchesSearch && matchesActive) {
                        employee.style.display = 'table-row';
                    } else {
                        employee.style.display = 'none';
                    }
                });
            }

            // Écouteur pour la barre de recherche
            document.getElementById('searchInput').addEventListener('input', filterEmployees);

            // Écouteur pour le filtre actif
            document.getElementById('activeFilter').addEventListener('change', filterEmployees);
        </script>
    </main>
@endsection