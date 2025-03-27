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
        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tableau des employés -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-4 flex flex-col sm:flex-row gap-4">
                <input type="text" id="searchInput" placeholder="Rechercher par nom, prénom, email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
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
                                data-prenom="{{ strtolower($employe->prenom) }}" data-email="{{ strtolower($employe->email) }}">
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
            document.getElementById('searchInput').addEventListener('input', function (e) {
                const searchTerm = e.target.value.toLowerCase();
                const employees = document.querySelectorAll('.employee-item');
                employees.forEach(employee => {
                    const nom = employee.getAttribute('data-nom');
                    const prenom = employee.getAttribute('data-prenom');
                    const email = employee.getAttribute('data-email');
                    if (nom.includes(searchTerm) || prenom.includes(searchTerm) || email.includes(searchTerm)) {
                        employee.style.display = 'table-row';
                    } else {
                        employee.style.display = 'none';
                    }
                });
            });
        </script>
    </main>
@endsection