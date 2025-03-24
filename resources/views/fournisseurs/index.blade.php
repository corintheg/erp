<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Gestion des Fournisseurs | ERP</title>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">


        <div class="flex-1 p-6">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl font-bold mb-6 text-gray-800">Gestion des Fournisseurs</h1>

                @if (session('success'))
                    <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <a href="{{ route('fournisseurs.create') }}"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                        + Nouveau fournisseur
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="mb-4 flex flex-col sm:flex-row gap-4">
                        <input type="text" id="searchInput" placeholder="Rechercher par nom de fournisseur..."
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
                                        <td class="px-4 py-3">{{ $fournisseur->nom }}</td>
                                        <td class="px-4 py-3">{{ $fournisseur->contact }}</td>
                                        <td class="px-4 py-3">{{ $fournisseur->email }}</td>
                                        <td class="px-4 py-3">{{ $fournisseur->telephone }}</td>
                                        <td class="px-4 py-3">{{ $fournisseur->adresse }}</td>
                                        <td class="px-4 py-3">
                                            @if ($fournisseur->site_web)
                                                <a href="{{ $fournisseur->site_web }}" target="_blank"
                                                    class="text-blue-500 underline">
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
                                                <form
                                                    action="{{ route('fournisseurs.destroy', $fournisseur->id_fournisseur) }}"
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
            </div>
        </div>
    </div>
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
</body>

</html>