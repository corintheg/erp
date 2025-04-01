@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm overflow-x-hidden">
        <!-- Header -->
        <header
            class="bg-white shadow p-4 rounded-lg mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-2xl font-semibold">Gestion Finance</h2>
            <a href="{{ route('finances.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouvelle entrée
            </a>
        </header>

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
                <input type="text" id="searchInput" placeholder="Rechercher par description..."
                    class="w-full sm:w-2/3 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button id="resetFilters"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    Remettre à zéro
                </button>
            </div>
        </div>

        <!-- Tableau desktop -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 hidden sm:block overflow-x-auto">
            <table class="w-full min-w-[1024px] text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Montant</th>
                        <th class="px-4 py-3">Date d'opération</th>
                        <th class="px-4 py-3">Catégorie</th>
                        <th class="px-4 py-3">Fournisseur</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3">Réf Facture</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="financeList">
                    @forelse ($finances as $finance)
                        <tr class="border-b hover:bg-gray-50 finance-item"
                            data-description="{{ strtolower($finance->description ?? '') }}">
                            <td class="px-4 py-3">{{ $finance->type_operation }}</td>
                            <td class="px-4 py-3">{{ $finance->description ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $finance->montant }}</td>
                            <td class="px-4 py-3">{{ $finance->date_operation }}</td>
                            <td class="px-4 py-3">{{ $finance->categorie }}</td>
                            <td class="px-4 py-3">{{ $finance->fournisseur->nom ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $finance->statut }}</td>
                            <td class="px-4 py-3">{{ $finance->reference_facture ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('finances.edit', $finance->id_finance) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">Éditer</a>
                                    <form action="{{ route('finances.destroy', $finance->id_finance) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-gray-500">Aucune entrée financière trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Cartes mobile -->
        <div class="sm:hidden space-y-4" id="financeListMobile">
            @forelse ($finances as $finance)
                <div class="finance-item border border-gray-200 rounded-lg p-4 shadow"
                    data-description="{{ strtolower($finance->description ?? '') }}">
                    <div class="mb-1"><strong>Type :</strong> {{ $finance->type_operation }}</div>
                    <div class="mb-1"><strong>Description :</strong> {{ $finance->description ?? 'N/A' }}</div>
                    <div class="mb-1"><strong>Montant :</strong> {{ $finance->montant }}</div>
                    <div class="mb-1"><strong>Date d'opération :</strong> {{ $finance->date_operation }}</div>
                    <div class="mb-1"><strong>Catégorie :</strong> {{ $finance->categorie }}</div>
                    <div class="mb-1"><strong>Fournisseur :</strong> {{ $finance->fournisseur->nom ?? 'N/A' }}</div>
                    <div class="mb-1"><strong>Statut :</strong> {{ $finance->statut }}</div>
                    <div class="mb-1"><strong>Réf Facture :</strong> {{ $finance->reference_facture ?? 'N/A' }}</div>
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('finances.edit', $finance->id_finance) }}"
                            class="flex-1 px-3 py-1 bg-blue-500 text-white text-center rounded-md hover:bg-blue-600">Éditer</a>
                        <form action="{{ route('finances.destroy', $finance->id_finance) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Aucune entrée financière trouvée.</p>
            @endforelse
        </div>
    </main>

    <script>
        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.finance-item').forEach(item => {
                const desc = item.getAttribute('data-description') || '';
                item.style.display = desc.includes(searchTerm) ? '' : 'none';
            });
        }

        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('resetFilters').addEventListener('click', () => {
            document.getElementById('searchInput').value = '';
            filterTable();
        });
    </script>
@endsection