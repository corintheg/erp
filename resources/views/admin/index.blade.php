<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Gestion des Utilisateurs | ERP</title>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <div class="flex-1 p-6">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Gestion des Utilisateurs</h1>

                @if (session('success'))
                    <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <a href="{{ route('admin.create') }}"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        + Nouvel utilisateur
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="mb-4 flex flex-col sm:flex-row gap-4">
                        <input type="text" id="searchInput" placeholder="Rechercher par nom d'utilisateur..."
                            class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]" />
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
                                    <th class="px-4 py-3 font-semibold text-gray-700">Nom d'utilisateur</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Rôles</th>
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
                                        <td class="px-4 py-3">
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.edit', $utilisateur->id_utilisateur) }}"
                                                    class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                                    Éditer
                                                </a>
                                                <form action="{{ route('admin.destroy', $utilisateur->id_utilisateur) }}"
                                                    method="POST">
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
                                        <td colspan="4" class="text-center py-4 text-gray-500">
                                            Aucun utilisateur trouvé.
                                        </td>
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
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const utilisateurs = document.getElementsByClassName('utilisateur-item');

            Array.from(utilisateurs).forEach((utilisateur) => {
                const name = utilisateur.getAttribute('data-name') || '';
                utilisateur.style.display = name.includes(searchTerm) ? 'table-row' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }
    </script>
</body>

</html>