@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Gestion du Stock</h2>
            <a href="{{ route('stocks.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouveau produit
            </a>
        </header>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-4 flex flex-col sm:flex-row gap-4">
                <input type="text" id="searchInput" placeholder="Rechercher par nom de produit..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button id="resetFilters"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    Remettre à zéro
                </button>
            </div>

            <div class="overflow-x-auto">
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
                                <td class="px-4 py-3">
                                    @if($stock->fournisseur)
                                        {{ $stock->fournisseur->nom }}
                                    @else
                                        N/A
                                    @endif
                                </td>
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
                                <td colspan="8" class="text-center py-4 text-gray-500">
                                    Aucun produit trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const stocks = document.getElementsByClassName('stock-item');
            Array.from(stocks).forEach((stock) => {
                const name = stock.getAttribute('data-name') || '';
                stock.style.display = name.includes(searchTerm) ? 'table-row' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }
    </script>
@endsection