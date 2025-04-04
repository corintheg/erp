@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-0 md:ml-64 p-4 sm:p-6 text-sm">
        <!-- Header -->
        <header
            class="bg-white shadow p-4 rounded-lg mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-2xl font-semibold">Salaires</h2>
            <a href="{{ route('salaires.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                + Nouveau salaire
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
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <input type="text" id="searchInput" placeholder="Rechercher par nom d'employé..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button id="resetFilters"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    Remettre à zéro
                </button>
            </div>
        </div>

        <!-- Liste des salaires -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="hidden sm:block overflow-x-auto">
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
                                <td class="px-4 py-3">{{ $salaire->employe->nom ?? 'N/A' }}
                                    {{ $salaire->employe->prenom ?? '' }}</td>
                                <td class="px-4 py-3">{{ number_format($salaire->montant, 2, ',', ' ') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($salaire->date_debut)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    {{ $salaire->date_fin ? \Carbon\Carbon::parse($salaire->date_fin)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
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
                                <td colspan="5" class="text-center py-4 text-gray-500">Aucun salaire trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Version mobile -->
            <div class="sm:hidden flex flex-col gap-4" id="salariesListMobile">
                @forelse ($salaires as $salaire)
                    <div class="salary-item bg-gray-50 border rounded-lg p-4 shadow-sm"
                        data-name="{{ strtolower($salaire->employe->nom ?? '') }} {{ strtolower($salaire->employe->prenom ?? '') }}">
                        <div class="text-base font-medium mb-1">
                            {{ $salaire->employe->nom ?? 'N/A' }} {{ $salaire->employe->prenom ?? '' }}
                        </div>
                        <div class="text-sm text-gray-600">Montant : {{ number_format($salaire->montant, 2, ',', ' ') }} €</div>
                        <div class="text-sm text-gray-600">Début :
                            {{ \Carbon\Carbon::parse($salaire->date_debut)->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-600 mb-2">Fin :
                            {{ $salaire->date_fin ? \Carbon\Carbon::parse($salaire->date_fin)->format('d/m/Y') : '-' }}</div>
                        <div class="flex gap-2">
                            <a href="{{ route('salaires.edit', $salaire->id_salaire) }}"
                                class="flex-1 text-center px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                                Éditer
                            </a>
                            <form action="{{ route('salaires.destroy', $salaire->id_salaire) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200"
                                    onclick="return confirm('Voulez-vous vraiment supprimer ce salaire ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Aucun salaire trouvé.</p>
                @endforelse
            </div>
        </div>

        <!-- Total salaires -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mt-6">
            <h3 class="text-lg font-medium mb-2">Total des Salaires</h3>
            <p class="text-2xl font-bold text-green-600">{{ number_format($totalSalaries, 2, ',', ' ') }} €</p>
            <p class="text-sm text-gray-500">Masse salariale actuelle</p>
        </div>
    </main>

    <script>
        const searchInput = document.getElementById('searchInput');
        const resetButton = document.getElementById('resetFilters');

        searchInput.addEventListener('input', filterSalaries);
        resetButton.addEventListener('click', () => {
            searchInput.value = '';
            filterSalaries();
        });

        function filterSalaries() {
            const term = searchInput.value.toLowerCase();
            document.querySelectorAll('.salary-item').forEach(item => {
                const name = item.getAttribute('data-name') || '';
                item.style.display = name.includes(term) ? '' : 'none';
            });
        }
    </script>
@endsection