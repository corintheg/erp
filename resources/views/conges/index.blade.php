@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <!-- Header avec titre et bouton d'ajout -->
        <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Gestion des Congés</h2>
            <a href="{{ route('conges.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouveau congé
            </a>
        </header>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Message de succès -->
        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Contenu principal -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Filtres -->
            <div class="mb-4 flex flex-col sm:flex-row gap-4">
                <select id="typeFilter"
                    class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    <option value="">Filtrer par type</option>
                    <option value="RTT">RTT</option>
                    <option value="CP">CP</option>
                    <option value="Maladie">Maladie</option>
                </select>
                <select id="statusFilter"
                    class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                    <option value="">Filtrer par statut</option>
                    <option value="En attente">En attente</option>
                    <option value="Validé">Validé</option>
                    <option value="Annulé">Annulé</option>
                </select>
                <input type="text" id="searchInput" placeholder="Rechercher par nom ou prénom..."
                    class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                <button id="resetFilters"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    Remettre à zéro
                </button>
            </div>

            <!-- Tableau des congés -->
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
                            <tr class="border-b hover:bg-gray-50 request-item" data-status="{{ $conge->statut }}"
                                data-type="{{ $conge->type_conge }}"
                                data-name="{{ strtolower($conge->employe->nom ?? '') }} {{ strtolower($conge->employe->prenom ?? '') }}">
                                <td class="px-4 py-3">
                                    {{ $conge->employe->nom ?? 'N/A' }} {{ $conge->employe->prenom ?? '' }}
                                </td>
                                <td class="px-4 py-3">{{ $conge->date_debut }}</td>
                                <td class="px-4 py-3">{{ $conge->date_fin }}</td>
                                <td class="px-4 py-3">{{ $conge->type_conge }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                                        {{ $conge->statut === 'Validé' ? 'bg-green-100 text-green-800' : ($conge->statut === 'Annulé' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $conge->statut }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $conge->commentaires ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if ($conge->statut === 'En attente')
                                        <div class="flex gap-2">
                                            <form action="{{ route('conges.approve', $conge->id_conge) }}" method="POST"
                                                class="flex items-center gap-2">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-[#38d62c] text-white rounded-md hover:bg-[#87e8b6] transition duration-200">
                                                    Approuver
                                                </button>
                                            </form>
                                            <form action="{{ route('conges.reject', $conge->id_conge) }}" method="POST"
                                                class="flex items-center gap-2">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
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
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    Aucune demande de congé trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Scripts de filtrage -->
    <script>
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
            filterTable();
        }
    </script>
@endsection