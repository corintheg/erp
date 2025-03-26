<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP System - Mouvements de Stock</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Animation pour la sidebar */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0 !important;
            }
            #search-bar-header {
                display: none !important;
            }
            #search-bar-sidebar {
                display: block !important;
            }
        }
        @media (min-width: 769px) {
            #burger-btn {
                display: none !important;
            }
        }
        #search-bar-sidebar {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans flex">

<!-- Bouton Burger -->
<button id="burger-btn" class="fixed bottom-6 right-6 z-50 p-4 text-white bg-green-600 rounded-full shadow">
    <i class="fas fa-bars text-2xl"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="sidebar w-64 bg-gray-800 text-[#55deaf] h-full fixed">
    <div class="p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">ERP System</h1>
        <button id="close-btn" class="md:hidden text-white">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div id="search-bar-sidebar" class="p-4">
        <div class="relative">
            <input type="text" placeholder="Rechercher un mouvement..." class="w-full bg-gray-700 text-white border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#55deaf]">
            <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>
    <nav class="mt-6">
        <a href="{{ route('dashboard') }}" class="flex items-center p-4 hover:bg-gray-700">
            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
        </a>
        <a href="{{ route('inventory') }}" class="flex items-center p-4 bg-gray-700">
            <i class="fas fa-warehouse mr-3"></i> Inventaire
        </a>
        <a href="{{ route('hr') }}" class="flex items-center p-4 hover:bg-gray-700">
            <i class="fas fa-users mr-3"></i> Ressources Humaines
        </a>
        <a href="{{ route('finances') }}" class="flex items-center p-4 hover:bg-gray-700">
            <i class="fas fa-chart-line mr-3"></i> Finances
        </a>
        <a href="{{ route('settings') }}" class="flex items-center p-4 hover:bg-gray-700">
            <i class="fas fa-cog mr-3"></i> Paramètres
        </a>
    </nav>
    <div class="absolute bottom-0 p-4">
        <a href="{{ route('logout') }}" class="flex items-center text-red-500 hover:text-red-400">
            <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="main-content flex-1 ml-64 p-6">
    <!-- Header -->
    <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Mouvements de Stock</h2>
        <div class="flex items-center space-x-4">
            <div id="search-bar-header" class="relative">
                <input type="text" placeholder="Rechercher un mouvement..." class="border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <div class="flex items-center">
                <i class="fas fa-user-circle text-2xl mr-2"></i>
                <span>{{ Auth::user()->name ?? 'Admin User' }}</span>
            </div>
        </div>
    </header>

    <!-- Stock Movements Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Card: Liste des Mouvements -->
        <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Liste des Mouvements</h3>
                <a href="{{ route('stock.create') }}" class="text-blue-600 hover:underline text-sm">Ajouter un mouvement</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 text-left">ID Produit</th>
                        <th class="p-2 text-left">Type</th>
                        <th class="p-2 text-left">Quantité</th>
                        <th class="p-2 text-left">Date</th>
                        <th class="p-2 text-left">Commentaire</th>
                        <th class="p-2 text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-b">
                        <td class="p-2">1</td>
                        <td class="p-2">Entrée</td>
                        <td class="p-2">100</td>
                        <td class="p-2">10/03/2025 10:00</td>
                        <td class="p-2">Réception initiale du stock</td>
                        <td class="p-2">
                            <a href="{{ route('stock.edit', 1) }}" class="text-blue-600 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('stock.delete', 1) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Voulez-vous vraiment supprimer ce mouvement ?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">2</td>
                        <td class="p-2">Entrée</td>
                        <td class="p-2">50</td>
                        <td class="p-2">10/03/2025 10:05</td>
                        <td class="p-2">Réception initiale du stock</td>
                        <td class="p-2">
                            <a href="{{ route('stock.edit', 2) }}" class="text-blue-600 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('stock.delete', 2) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Voulez-vous vraiment supprimer ce mouvement ?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">1</td>
                        <td class="p-2">Sortie</td>
                        <td class="p-2">10</td>
                        <td class="p-2">15/03/2025 15:00</td>
                        <td class="p-2">Vente</td>
                        <td class="p-2">
                            <a href="{{ route('stock.edit', 3) }}" class="text-blue-600 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('stock.delete', 3) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Voulez-vous vraiment supprimer ce mouvement ?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card: Répartition des Mouvements -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Répartition des Mouvements</h3>
            <canvas id="movementDistributionChart" height="150"></canvas>
        </div>

        <!-- Card: Évolution des Quantités -->
        <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
            <h3 class="text-lg font-medium mb-4">Évolution des Quantités</h3>
            <canvas id="quantityEvolutionChart" height="150"></canvas>
        </div>

        <!-- Card: Stock Total -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Stock Total</h3>
            <p class="text-2xl font-bold text-green-600">140</p>
            <p class="text-sm text-gray-500">Quantité totale en stock</p>
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

    // Répartition des Mouvements - Pie Chart
    const movementDistributionData = {
        labels: ['Entrées', 'Sorties'],
        datasets: [{
            label: 'Quantité',
            data: [150, 10], // Calculé à partir des données : 100+50 entrées, 10 sorties
            backgroundColor: ['rgba(0,153,255,0.6)', 'rgba(255,0,55,0.6)'],
            borderColor: ['rgba(0,153,255,0.6)', 'rgba(255,0,55,0.6)'],
            borderWidth: 1
        }]
    };

    new Chart(document.getElementById('movementDistributionChart').getContext('2d'), {
        type: 'pie',
        data: movementDistributionData,
        options: {
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12 } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' unités';
                        }
                    }
                }
            }
        }
    });

    // Évolution des Quantités - Line Chart
    const quantityEvolutionData = {
        labels: ['10/03/2025', '15/03/2025'],
        datasets: [
            {
                label: 'Produit 1',
                data: [100, 90], // 100 entrées - 10 sorties
                borderColor: 'rgba(0,153,255,0.6)',
                fill: false
            },
            {
                label: 'Produit 2',
                data: [50, 50], // 50 entrées, pas de sorties
                borderColor: 'rgba(255,185,0,0.6)',
                fill: false
            }
        ]
    };

    new Chart(document.getElementById('quantityEvolutionChart').getContext('2d'), {
        type: 'line',
        data: quantityEvolutionData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' unités';
                        }
                    }
                }
            },
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' unités';
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>