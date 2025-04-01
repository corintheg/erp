@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <!-- Header -->
        <header
            class="bg-white shadow p-4 rounded-lg mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <h2 class="text-2xl font-semibold">Gestion du Stock</h2>
            <a href="{{ route('stocks.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouveau produit
            </a>
        </header>

        <!-- Alertes -->
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
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="mb-4 flex flex-col sm:flex-row gap-4">
                <input type="text" id="searchInput" placeholder="Rechercher par nom de produit..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button id="resetFilters"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    Remettre à zéro
                </button>
            </div>

            <!-- Table or Cards -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Nom</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Fournisseur</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Quantité</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Seuil Alerte</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Prix Achat</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Prix Vente</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="stockList">
                        @forelse ($stocks as $stock)
                            <tr class="border-b hover:bg-gray-50 stock-item" data-name="{{ strtolower($stock->nom_produit) }}">
                                <td class="px-4 py-3">{{ $stock->id_produit }}</td>
                                <td class="px-4 py-3">{{ $stock->nom_produit }}</td>
                                <td class="px-4 py-3">{{ $stock->fournisseur->nom ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $stock->quantite ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $stock->seuil_alerte ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $stock->prix_achat ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $stock->prix_vente ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('stocks.edit', $stock->id_produit) }}"
                                            class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                            Éditer
                                        </a>
                                        <form action="{{ route('stocks.destroy', $stock->id_produit) }}" method="POST">
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
                                <td colspan="8" class="text-center py-4 text-gray-500">Aucun produit trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile view -->
            <div class="sm:hidden space-y-4 mt-4" id="stockCards">
                @forelse ($stocks as $stock)
                    <div class="stock-item border border-gray-200 rounded-lg p-4 shadow"
                        data-name="{{ strtolower($stock->nom_produit) }}">
                        <p><strong>ID :</strong> {{ $stock->id_produit }}</p>
                        <p><strong>Nom :</strong> {{ $stock->nom_produit }}</p>
                        <p><strong>Fournisseur :</strong> {{ $stock->fournisseur->nom ?? 'N/A' }}</p>
                        <p><strong>Quantité :</strong> {{ $stock->quantite ?? 'N/A' }}</p>
                        <p><strong>Seuil Alerte :</strong> {{ $stock->seuil_alerte ?? 'N/A' }}</p>
                        <p><strong>Prix Achat :</strong> {{ $stock->prix_achat ?? 'N/A' }}</p>
                        <p><strong>Prix Vente :</strong> {{ $stock->prix_vente ?? 'N/A' }}</p>
                        <div class="flex gap-2 mt-2">
                            <a href="{{ route('stocks.edit', $stock->id_produit) }}"
                                class="flex-1 px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 text-center">
                                Éditer
                            </a>
                            <form action="{{ route('stocks.destroy', $stock->id_produit) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Aucun produit trouvé.</p>
                @endforelse
            </div>
        </div>
    </main>

    <script>
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const items = document.querySelectorAll('.stock-item');
            items.forEach((item) => {
                const name = item.getAttribute('data-name') || '';
                item.style.display = name.includes(searchTerm) ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }
    </script>
@endsection