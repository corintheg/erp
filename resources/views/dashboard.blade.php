@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-64 p-6">
        <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Tableau de Bord</h2>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-2xl mr-2"></i>
                    <span class="first-letter:uppercase">{{ Auth::user()->username ?? 'Admin User' }}</span>
                </div>
            </div>
        </header>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif


        <!-- Dashboard Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Card: Employés -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Répartition des Employés</h3>
                    <a href="/hr" class="text-blue-600 hover:underline text-sm">Voir plus</a>
                </div>
                <canvas id="employeeChart" height="150"></canvas>
            </div>

            <!-- Card: Finances -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Revenus vs Dépenses</h3>
                    <a href="/finance" class="text-blue-600 hover:underline text-sm">Voir plus</a>
                </div>
                <canvas id="financeChart" height="150"></canvas>
            </div>

            <!-- Card: Stock -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Stock des Produits</h3>
                    <a href="/inventory" class="text-blue-600 hover:underline text-sm">Voir plus</a>
                </div>
                <canvas id="stockChart" height="150"></canvas>
            </div>
        </div>
    </main>
    <script>
        // JavaScript pour gérer l'ouverture/fermeture de la sidebar
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

        // Configuration Chart.js globale
        Chart.defaults.font.size = 12;

        // Employés - Changement en Doughnut
        const employeeData = @json($employeeStats);
        const employeeLabels = employeeData.map(e => e.nom_role);
        const employeeCounts = employeeData.map(e => e.total);

        new Chart(document.getElementById('employeeChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: employeeLabels,
                datasets: [{
                    label: 'Nombre d\'employés',
                    data: employeeCounts,
                    backgroundColor: [
                        'rgba(0,153,255,0.6)',
                        'rgb(247,142,255)',
                        'rgb(0,255,255)',
                        'rgba(25,255,0,0.6)',
                        'rgba(255,185,0,0.6)',
                        'rgba(104,0,142,0.6)',
                        'rgba(255,0,0,0.6)'
                    ],
                    borderColor: [
                        'rgba(0,153,255,0.6)',
                        'rgb(247,142,255)',
                        'rgb(0,255,255)',
                        'rgba(25,255,0,0.6)',
                        'rgba(255,185,0,0.6)',
                        'rgba(104,0,142,0.6)',
                        'rgba(255,0,0,0.6)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                cutout: '50%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12
                        }
                    }
                }
            }
        });

        // Finances - Pie amélioré
        const financeData = @json($financeStats);
        new Chart(document.getElementById('financeChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Revenus', 'Dépenses'],
                datasets: [{
                    data: [financeData.revenus, financeData.depenses],
                    backgroundColor: ['rgba(0,104,255,0.6)', 'rgba(255,0,55,1)'],
                    borderColor: ['rgba(0,104,255,0.6)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(context.parsed);
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Stock - Changement en Barres Horizontales
        const stockData = @json($stockStats);
        const stockLabels = stockData.map(s => s.nom_produit);
        const stockValues = stockData.map(s => s.quantite);

        new Chart(document.getElementById('stockChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: stockLabels,
                datasets: [{
                    label: 'Quantité en stock',
                    data: stockValues,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.label}: ${context.parsed} unités`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection