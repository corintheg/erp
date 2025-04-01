@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <!-- Header -->
        <header
            class="bg-white shadow p-4 rounded-lg mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-2xl font-semibold">Gestion des Utilisateurs</h2>
            <a href="{{ route('admin.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouvel utilisateur
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
                <input type="text" id="searchInput" placeholder="Rechercher par nom d'utilisateur..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                <button id="resetFilters"
                    class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    Remettre à zéro
                </button>
            </div>
        </div>

        <!-- Liste responsive -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <!-- Desktop Table -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Nom d'utilisateur</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Rôles</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Date de création</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="utilisateursList">
                        @forelse ($utilisateurs as $utilisateur)
                            <tr class="border-b hover:bg-gray-50 utilisateur-item"
                                data-name="{{ strtolower($utilisateur->username) }}">
                                <td class="px-4 py-3">{{ $utilisateur->id_utilisateur }}</td>
                                <td class="px-4 py-3">{{ $utilisateur->username }}</td>
                                <td class="px-4 py-3">
                                    {{ $utilisateur->roles->pluck('nom_role')->join(', ') }}
                                </td>
                                <td class="px-4 py-3">{{ $utilisateur->date_creation }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.edit', $utilisateur->id_utilisateur) }}"
                                            class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                            Éditer
                                        </a>
                                        <form action="{{ route('admin.destroy', $utilisateur->id_utilisateur) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200"
                                                onclick="return confirm('Supprimer cet utilisateur ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">
                                    Aucun utilisateur trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="sm:hidden space-y-4" id="utilisateursCards">
                @forelse ($utilisateurs as $utilisateur)
                    <div class="border border-gray-200 rounded-lg p-4 shadow utilisateur-item"
                        data-name="{{ strtolower($utilisateur->username) }}">
                        <div class="mb-2"><span class="font-semibold">ID :</span> {{ $utilisateur->id_utilisateur }}</div>
                        <div class="mb-2"><span class="font-semibold">Nom :</span> {{ $utilisateur->username }}</div>
                        <div class="mb-2"><span class="font-semibold">Rôles :</span>
                            {{ $utilisateur->roles->pluck('nom_role')->join(', ') }}</div>
                        <div class="mb-2"><span class="font-semibold">Créé le :</span> {{ $utilisateur->date_creation }}</div>
                        <div class="grid grid-cols-2 sm:flex gap-2 mt-3">
                            <a href="{{ route('admin.edit', $utilisateur->id_utilisateur) }}"
                                class="w-full text-center px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                Éditer
                            </a>
                            <form action="{{ route('admin.destroy', $utilisateur->id_utilisateur) }}" method="POST"
                                class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full text-center px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200"
                                    onclick="return confirm('Supprimer cet utilisateur ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <p class="text-center text-gray-500">Aucun utilisateur trouvé.</p>
                @endforelse
            </div>
        </div>
    </main>

    <script>
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const utilisateurs = document.querySelectorAll('.utilisateur-item');
            utilisateurs.forEach((utilisateur) => {
                const name = utilisateur.getAttribute('data-name') || '';
                utilisateur.style.display = name.includes(searchTerm) ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }
    </script>
@endsection