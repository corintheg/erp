@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-6 text-sm">
        <!-- Header de la page -->
        <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Salaires</h2>
            <a href="{{ route('salaires.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouveau salaire
            </a>
        </header>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Contenu principal -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-4 flex flex-col sm:flex-row gap-4">
                <input type="text" id="searchInput" placeholder="Rechercher par nom d'employé..."
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
                            <th class="px-4 py-3 font-semibold text-gray-700">Employé</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Montant (€)</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Date Début</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Date Fin</th>
                            <th class="px-4 py-3 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="salariesList">
                        @forelse ($salaires as $salaire)
                            <tr class="border-b hover:bg-gray-50 salary-item"
                                data-name="{{ strtolower($salaire->employe->nom ?? '') }} {{ strtolower($salaire->employe->prenom ?? '') }}">
                                <td class="px-4 py-3">
                                    {{ $salaire->employe->nom ?? 'N/A' }} {{ $salaire->employe->prenom ?? '' }}
                                </td>
                                <td class="px-4 py-3">{{ number_format($salaire->montant, 2, ',', ' ') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($salaire->date_debut)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    {{ $salaire->date_fin ? \Carbon\Carbon::parse($salaire->date_fin)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('salaires.edit', $salaire->id_salaire) }}"
                                            class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                            Éditer
                                        </a>
                                        <form action="{{ route('salaires.destroy', $salaire->id_salaire) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200"
                                                onclick="return confirm('Voulez-vous vraiment supprimer ce salaire ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">
                                    Aucun salaire trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistiques de masse salariale totale -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-medium mb-4">Total des Salaires</h3>
            <p class="text-2xl font-bold text-green-600" id="total-salaries">
                {{ number_format($totalSalaries, 2, ',', ' ') }} €
            </p>
            <p class="text-sm text-gray-500">Masse salariale actuelle</p>
        </div>
    </main>

    <script>
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const salaries = document.getElementsByClassName('salary-item');
            Array.from(salaries).forEach((salaire) => {
                const name = salaire.getAttribute('data-name') || '';
                salaire.style.display = name.includes(searchTerm) ? 'table-row' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }
    </script>
@endsection