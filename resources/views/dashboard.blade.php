<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP System - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans flex">

<!-- Sidebar -->
<aside class="w-64 bg-gray-800 text-white h-screen fixed">
    <div class="p-4">
        <h1 class="text-2xl font-bold">ERP System</h1>
    </div>
    <nav class="mt-6">
        <a href="/dashboard" class="flex items-center p-4 hover:bg-gray-700">
            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
        </a>
        <a href="/inventory" class="flex items-center p-4 hover:bg-gray-700">
            <i class="fas fa-warehouse mr-3"></i> Inventaire
        </a>
        <a href="/hr" class="flex items-center p-4 hover:bg-gray-700">
            <i class="fas fa-users mr-3"></i> Ressources Humaines
        </a>
        <a href="/finance" class="flex items-center p-4 hover:bg-gray-700">
            <i class="fas fa-chart-line mr-3"></i> Finances
        </a>
        <a href="/settings" class="flex items-center p-4 hover:bg-gray-700">
            <i class="fas fa-cog mr-3"></i> Paramètres
        </a>
    </nav>
    <div class="absolute bottom-0 p-4">
        <a href="/logout" class="flex items-center text-red-300 hover:text-red-400">
            <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="flex-1 ml-64 p-6">
    <!-- Header -->
    <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Tableau de Bord</h2>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" placeholder="Rechercher..."
                       class="border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <div class="flex items-center">
                <i class="fas fa-user-circle text-2xl mr-2"></i>
                <span>Admin User</span>
            </div>
        </div>
    </header>

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

        <!-- Card: Notifications -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Notifications</h3>
            <ul class="space-y-2">
                <li class="flex items-center text-sm">
                    <i class="fas fa-exclamation-circle text-yellow-500 mr-2"></i>
                    Stock faible: Produit A
                </li>
                <li class="flex items-center text-sm">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    Paiement reçu
                </li>
            </ul>
        </div>

        <!-- Card: Tâches -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Tâches en cours</h3>
            <ul class="space-y-2">
                <li class="flex items-center text-sm">
                    <input type="checkbox" class="mr-2">
                    Vérifier inventaire Q1
                </li>
                <li class="flex items-center text-sm">
                    <input type="checkbox" class="mr-2">
                    Réunion équipe RH
                </li>
            </ul>
        </div>
    </div>
</main>
<script>
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
            cutout: '50%', // Pour l'effet donut
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
                        label: function(context) {
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
            indexAxis: 'y', // Pour des barres horizontales
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
                        label: function(context) {
                            return `${context.label}: ${context.parsed} unités`;
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>