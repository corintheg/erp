<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Gestion des Congés | ERP</title>
</head>
<body class="bg-gray-100">
<div class="flex min-h-screen">
    <!-- Barre latérale -->
    <div class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white shadow-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-8">Système ERP</h2>
            <nav class="space-y-4">
                <a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">Tableau de bord</a>
                <a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">Employés</a>
                <a href="{{ route('leave.approval') }}" class="block px-4 py-2 rounded-md bg-gray-700">Congés</a>
                <a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">Rapports</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
                        Déconnexion
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1 ml-64 p-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Gestion des Congés</h1>

            <!-- Message de succès -->
            @if (session('success'))
                <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tableau des demandes de congés -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Filtres -->
                <div class="mb-4 flex flex-col sm:flex-row gap-4">
                    <select id="typeFilter" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        <option value="">Filtrer par type</option>
                        <option value="RTT">RTT</option>
                        <option value="CP">CP</option>
                        <option value="Maladie">Maladie</option>
                    </select>
                    <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                        <option value="">Filtrer par statut</option>
                        <option value="En attente">En attente</option>
                        <option value="Validé">Validé</option>
                        <option value="Annulé">Annulé</option>
                    </select>
                    <input
                            type="text"
                            id="searchInput"
                            placeholder="Rechercher par nom ou prénom..."
                            class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]"
                    >
                    <button id="resetFilters" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                        Remettre à zéro
                    </button>
                </div>

                <!-- Tableau -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-gray-700">Employé</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Date de début</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Date de fin</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Type</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Statut</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Commentaires</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Actions</th>
                        </tr>
                        </thead>
                        <tbody id="leaveRequests">
                        @forelse ($conges as $conge)
                            <tr class="border-b hover:bg-gray-50 request-item"
                                data-status="{{ $conge->statut }}"
                                data-type="{{ $conge->type_conge }}"
                                data-name="{{ strtolower($conge->employe->nom ?? '') }} {{ strtolower($conge->employe->prenom ?? '') }}">
                                <td class="px-4 py-3">{{ $conge->employe->nom ?? 'N/A' }} {{ $conge->employe->prenom ?? '' }}</td>
                                <td class="px-4 py-3">{{ $conge->date_debut }}</td>
                                <td class="px-4 py-3">{{ $conge->date_fin }}</td>
                                <td class="px-4 py-3">{{ $conge->type_conge }}</td>
                                <td class="px-4 py-3">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                            {{ ($conge->statut === 'Validé' ? 'bg-green-100 text-green-800' : ($conge->statut === 'Annulé' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                            {{ $conge->statut }}
                                        </span>
                                </td>
                                <td class="px-4 py-3">{{ $conge->commentaires ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if ($conge->statut === 'En attente')
                                        <div class="flex gap-2">
                                            <form action="{{ route('leave.approve', $conge->id_conge) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-[#38d62c] text-white rounded-md hover:bg-[#87e8b6] transition duration-200">
                                                    Approuver
                                                </button>
                                            </form>
                                            <form action="{{ route('leave.reject', $conge->id_conge) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                                                    Refuser
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Action terminée</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">Aucune demande de congé trouvée.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fonction de filtrage
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('statusFilter').addEventListener('change', filterTable);
    document.getElementById('typeFilter').addEventListener('change', filterTable);
    document.getElementById('resetFilters').addEventListener('click', resetFilters);

    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const typeFilter = document.getElementById('typeFilter').value;
        const requests = document.getElementsByClassName('request-item');

        Array.from(requests).forEach(request => {
            const fullName = request.getAttribute('data-name');
            const status = request.getAttribute('data-status');
            const type = request.getAttribute('data-type');

            const matchesSearch = fullName.includes(searchTerm);
            const matchesStatus = !statusFilter || status === statusFilter;
            const matchesType = !typeFilter || type === typeFilter;

            request.style.display = (matchesSearch && matchesStatus && matchesType) ? 'table-row' : 'none';
        });
    }

    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('typeFilter').value = '';
        filterTable(); // Réapplique le filtre pour afficher toutes les lignes
    }
</script>
</body>
</html>