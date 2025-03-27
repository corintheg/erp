@extends('layouts.app')

@section('content')

    <main class="main-content flex-1 ml-64 p-6">
        <!-- Header -->
        <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Salaires</h2>
            <div class="flex items-center space-x-4">
                <div id="search-bar-header" class="relative">
                    <input type="text" placeholder="Rechercher un salaire..."
                        class="border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-2xl mr-2"></i>
                    <span>{{ Auth::user()->username ?? 'Admin User' }}</span>
                </div>
            </div>
        </header>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        <!-- Salaries Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Card: Liste des Salaires -->
            <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Liste des Salaires</h3>
                    <a href="{{ route('salaries.create') }}" class="text-blue-600 hover:underline text-sm">Ajouter un
                        salaire</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2 text-left">Employé</th>
                                <th class="p-2 text-left">Montant (€)</th>
                                <th class="p-2 text-left">Date Début</th>
                                <th class="p-2 text-left">Date Fin</th>
                                <th class="p-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salaries as $salaire)
                                <tr class="border-b">
                                    <td class="p-2">{{ $salaire->employe ? $salaire->employe->nom : 'Inconnu' }}</td>
                                    <td class="p-2">{{ number_format($salaire->montant, 2, ',', ' ') }}</td>
                                    <td class="p-2">{{ $salaire->date_debut->format('d/m/Y') }}</td>
                                    <td class="p-2">{{ $salaire->date_fin ? $salaire->date_fin->format('d/m/Y') : '-' }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('salaries.edit', $salaire->id_salaire) }}"
                                            class="text-blue-600 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('salaries.delete', $salaire->id_salaire) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline"
                                                onclick="return confirm('Voulez-vous vraiment supprimer ce salaire ?')"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card: Répartition des Salaires -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4">Répartition des Salaires</h3>
                <canvas id="salaryDistributionChart" height="150"></canvas>
            </div>

            <!-- Card: Évolution des Salaires -->
            <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
                <h3 class="text-lg font-medium mb-4">Évolution des Salaires</h3>
                <canvas id="salaryEvolutionChart" height="150"></canvas>
            </div>

            <!-- Card: Total Salaires -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4">Total des Salaires</h3>
                <p class="text-2xl font-bold text-green-600">{{ number_format($totalSalaries, 2, ',', ' ') }} €</p>
                <p class="text-sm text-gray-500">Masse salariale actuelle</p>
            </div>
        </div>
    </main>

    <script>
        // Gestion de la sidebar
        const sidebar = document.getElementById('sidebar');
        const burgerBtn = document.getElementById('burger-btn');
        const closeBtn = document.getElementById('close-btn');

        burgerBtn.addEventListener('click', () => {
            sidebar.classList.add('open');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('open');
        });

        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !burgerBtn.contains(e.target) && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // Configuration Chart.js
        Chart.defaults.font.size = 12;

        // Répartition des Salaires - Pie Chart
        const salaryDistributionData = {
            labels: @json($salaryDistribution->pluck('nom')),
            datasets: [{
                label: 'Montant (€)',
                data: @json($salaryDistribution->pluck('montant')),
                backgroundColor: ['rgba(0,153,255,0.6)', 'rgba(255,185,0,0.6)', 'rgba(25,255,0,0.6)', 'rgba(255,0,55,0.6)'],
                borderColor: ['rgba(0,153,255,0.6)', 'rgba(255,185,0,0.6)', 'rgba(25,255,0,0.6)', 'rgba(255,0,55,0.6)'],
                borderWidth: 1
            }]
        };

        new Chart(document.getElementById('salaryDistributionChart').getContext('2d'), {
            type: 'pie',
            data: salaryDistributionData,
            options: {
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12 } },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.label + ': ' + new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(context.parsed);
                            }
                        }
                    }
                }
            }
        });

        // const salaryEvolutionData = {
        { { --labels: @json($salaryEvolution->pluck('data')->flatten(1)->pluck('date_debut')->unique()->sort()), --} }

        { --datasets: @json($salaryEvolution -> map(function ($item) { --}}
        //         return [
        //             'label' => $item['nom'],
        //             'data' => array_column($item['data'], 'montant'),
        //             'borderColor' => 'rgba(' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random()*255) + ',' + Math.floor(Math.random()*255) + ',0.6)',
        //             'fill' => false
        //         ];
        //     })->values())
        // };

        new Chart(document.getElementById('salaryEvolutionChart').getContext('2d'), {
            type: 'line',
            data: salaryEvolutionData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(value);
                            }
                        }
                    }
                },
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label + ': ' + new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(context.parsed.y);
                            }
                        }
                    }
                }
            }
        });
    </script>
    </body>

    </html>
@endsection