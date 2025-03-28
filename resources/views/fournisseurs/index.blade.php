@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <!-- Header de la page -->
        <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Gestion des Fournisseurs</h2>
            <a href="{{ route('fournisseurs.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouveau fournisseur
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

        <!-- Contenu principal -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-4 flex flex-col sm:flex-row gap-4">
                <input type="text" id="searchInput" placeholder="Rechercher par nom de fournisseur..."
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
                            <th class="px-4 py-3 font-semibold text-gray-700">Nom</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Contact</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Email</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Téléphone</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Adresse</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Site web</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="fournisseursList">
                        @forelse ($fournisseurs as $fournisseur)
                            <tr class="border-b hover:bg-gray-50 fournisseur-item"
                                data-name="{{ strtolower($fournisseur->nom) }}">
                                <td class="px-4 py-3">(ID: {{ $fournisseur->id_fournisseur }}) {{ $fournisseur->nom }}</td>
                                <td class="px-4 py-3">{{ $fournisseur->contact }}</td>
                                <td class="px-4 py-3">{{ $fournisseur->email }}</td>
                                <td class="px-4 py-3">{{ $fournisseur->telephone }}</td>
                                <td class="px-4 py-3">{{ $fournisseur->adresse }}</td>
                                <td class="px-4 py-3">
                                    @if ($fournisseur->site_web)
                                        <a href="{{ $fournisseur->site_web }}" target="_blank" class="text-blue-500 underline">
                                            {{ $fournisseur->site_web }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('fournisseurs.edit', $fournisseur->id_fournisseur) }}"
                                            class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                            Éditer
                                        </a>
                                        <form action="{{ route('fournisseurs.destroy', $fournisseur->id_fournisseur) }}"
                                            method="POST">
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
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    Aucun fournisseur trouvé.
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
            const fournisseurs = document.getElementsByClassName('fournisseur-item');
            Array.from(fournisseurs).forEach((fournisseur) => {
                const name = fournisseur.getAttribute('data-name') || '';
                fournisseur.style.display = name.includes(searchTerm) ? 'table-row' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }
    </script>
@endsection