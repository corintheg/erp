@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <!-- En-tête -->
        <header
            class="bg-white shadow p-4 rounded-lg mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-2xl font-semibold">Gestion des Commandes</h2>
            <a href="{{ route('commandes.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouvelle commande
            </a>
        </header>

        <!-- Messages -->
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

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4">
            <div class="mb-4 flex flex-col sm:flex-row gap-4">
                <input type="text" id="searchInput" placeholder="Rechercher par référence de commande..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button id="resetFilters"
                    class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    Remettre à zéro
                </button>
            </div>
        </div>

        <!-- Liste responsive -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <!-- Table desktop -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Référence</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Fournisseur</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Destinataire</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Statut</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Date livraison</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Date création</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="commandesList">
                        @forelse ($commandes as $commande)
                                            @php
                                                $statusClasses = [
                                                    'Annulé' => 'bg-red-200 text-red-700',
                                                    'En cours' => 'bg-blue-200 text-blue-700',
                                                    'Livrée' => 'bg-green-200 text-green-700',
                                                ];
                                                $classe = $statusClasses[$commande->statut_livraison] ?? 'bg-gray-200 text-gray-700';
                                            @endphp

                                            <tr class="border-b hover:bg-gray-50 commande-item"
                                                data-reference="{{ strtolower($commande->reference_commande) }}">
                                                <td class="px-4 py-3">{{ $commande->id_livraison }}</td>
                                                <td class="px-4 py-3">{{ $commande->reference_commande }}</td>
                                                <td class="px-4 py-3">{{ $commande->fournisseur->nom ?? 'N/A' }}</td>
                                                <td class="px-4 py-3">{{ $commande->destinataire ?? 'N/A' }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $classe }}">
                                                        {{ $commande->statut_livraison }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">{{ $commande->date_livraison }}</td>
                                                <td class="px-4 py-3">{{ $commande->date_creation }}</td>
                                                <td class="px-4 py-3">
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('commandes.edit', $commande->id_livraison) }}"
                                                            class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                                            Éditer
                                                        </a>
                                                        <form action="{{ route('commandes.destroy', $commande->id_livraison) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200"
                                                                onclick="return confirm('Supprimer cette commande ?')">
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">
                                    Aucune commande trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Cartes mobile -->
            <div class="sm:hidden space-y-4" id="commandesCards">
                @forelse ($commandes as $commande)
                            @php
                                $statusClasses = [
                                    'Annulé' => 'bg-red-200 text-red-700',
                                    'En cours' => 'bg-blue-200 text-blue-700',
                                    'Livrée' => 'bg-green-200 text-green-700',
                                ];
                                $classe = $statusClasses[$commande->statut_livraison] ?? 'bg-gray-200 text-gray-700';
                            @endphp
                            <div class="border border-gray-200 rounded-lg p-4 shadow commande-item"
                                data-reference="{{ strtolower($commande->reference_commande) }}">
                                <div class="mb-2"><span class="font-semibold">ID :</span> {{ $commande->id_livraison }}</div>
                                <div class="mb-2"><span class="font-semibold">Référence :</span> {{ $commande->reference_commande }}
                                </div>
                                <div class="mb-2"><span class="font-semibold">Fournisseur :</span>
                                    {{ $commande->fournisseur->nom ?? 'N/A' }}</div>
                                <div class="mb-2"><span class="font-semibold">Destinataire :</span>
                                    {{ $commande->destinataire ?? 'N/A' }}</div>
                                <div class="mb-2">
                                    <span class="font-semibold">Statut :</span>
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $classe }}">
                                        {{ $commande->statut_livraison }}
                                    </span>
                                </div>
                                <div class="mb-2"><span class="font-semibold">Livraison :</span> {{ $commande->date_livraison }}</div>
                                <div class="mb-2"><span class="font-semibold">Création :</span> {{ $commande->date_creation }}</div>
                                <div class="grid grid-cols-2 gap-2 mt-3">
                                    <a href="{{ route('commandes.edit', $commande->id_livraison) }}"
                                        class="w-full text-center px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                        Éditer
                                    </a>
                                    <form action="{{ route('commandes.destroy', $commande->id_livraison) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full text-center px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200"
                                            onclick="return confirm('Supprimer cette commande ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                @empty
                    <p class="text-center text-gray-500">Aucune commande trouvée.</p>
                @endforelse
            </div>
        </div>
    </main>

    <!-- JS filtre -->
    <script>
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const items = document.querySelectorAll('.commande-item');
            items.forEach((item) => {
                const reference = item.getAttribute('data-reference') || '';
                item.style.display = reference.includes(searchTerm) ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }
    </script>
@endsection