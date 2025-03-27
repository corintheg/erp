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
    <button id="burger-btn" class="fixed bottom-6 right-6 z-50 p-4 text-white bg-green-600 rounded-full shadow">
        <i class="fas fa-bars text-2xl"></i>
    </button>
    <aside id="sidebar" class="sidebar w-64 bg-gray-800 text-[#55deaf] h-full fixed">
        <div class="p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">ERP System</h1>
            <button id="close-btn" class="md:hidden text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="search-bar-sidebar" class="p-4">
            <div class="relative">
                <input type="text" id="search-sidebar" placeholder="Rechercher un mouvement..."
                    class="w-full bg-gray-700 text-white border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#55deaf]">
                <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
        <nav class="mt-6">
            <a href="#" class="flex items-center p-4 hover:bg-gray-700">
                <i class="fas fa-tachometer-alt mr-3"></i> Tableau de bord
            </a>
            <a href="#" class="flex items-center p-4 bg-gray-700">
                <i class="fas fa-warehouse mr-3"></i> Inventaire
            </a>
            <a href="#" class="flex items-center p-4 hover:bg-gray-700">
                <i class="fas fa-users mr-3"></i> Ressources Humaines
            </a>
            <a href="#" class="flex items-center p-4 hover:bg-gray-700">
                <i class="fas fa-chart-line mr-3"></i> Finances
            </a>
            <a href="#" class="flex items-center p-4 hover:bg-gray-700">
                <i class="fas fa-cog mr-3"></i> Paramètres
            </a>
        </nav>
        <div class="absolute bottom-0 p-4">
            <a href="#" class="flex items-center text-red-500 hover:text-red-400">
                <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
            </a>
        </div>
    </aside>
    <main class="main-content flex-1 ml-64 p-6">
        <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Mouvements de Stock</h2>
            <div class="flex items-center space-x-4">
                <div id="search-bar-header" class="relative">
                    <input type="text" id="search-header" placeholder="Rechercher un mouvement..."
                        class="border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-2xl mr-2"></i>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Liste des Mouvements</h3>
                    <a href="#" class="text-blue-600 hover:underline text-sm">Ajouter un mouvement</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="movements-table">
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
                        <tbody id="movements-body">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4">Répartition des Mouvements</h3>
                <canvas id="movementDistributionChart" height="150"></canvas>
            </div>
            <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
                <h3 class="text-lg font-medium mb-4">Évolution des Quantités</h3>
                <canvas id="quantityEvolutionChart" height="150"></canvas>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4">Stock Total</h3>
                <p class="text-2xl font-bold text-green-600" id="total-stock">0</p>
                <p class="text-sm text-gray-500">Quantité totale en stock</p>
            </div>
        </div>
    </main>
    <script>
        const sidebar = document.getElementById('sidebar');
        const burgerBtn = document.getElementById('burger-btn');
        const closeBtn = document.getElementById('close-btn');
        const searchHeader = document.getElementById('search-header');
        const searchSidebar = document.getElementById('search-sidebar');
        const movementsBody = document.getElementById('movements-body');

        burgerBtn.addEventListener('click', () => sidebar.classList.add('open'));
        closeBtn.addEventListener('click', () => sidebar.classList.remove('open'));
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !burgerBtn.contains(e.target) && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        const stocksData = [
            { id_produit: 1, description: "", quantite: 90, seuil_alerte: 20, id_fournisseur: 1, prix_achat: 15.00, prix_vente: 25.00, date_creation: "2025-03-10 10:00:00" },
            { id_produit: 2, description: "", quantite: 50, seuil_alerte: 10, id_fournisseur: 2, prix_achat: 10.00, prix_vente: 18.00, date_creation: "2025-03-10 10:05:00" }
        ];

        const movementsData = [
            { id_produit: 1, type: "", quantite: 100, date: "", commentaire: "Réception" },
            { id_produit: 2, type: "", quantite: 50, date: "", commentaire: "Réception" },
        ];

        // Fonction pour afficher les mouvements avec filtrage
        function renderMovements(filter = '') {
            movementsBody.innerHTML = '';
            const filteredMovements = movementsData.filter(movement => {
                const searchText = filter.toLowerCase().trim();
                return (
                    movement.id_produit.toString().includes(searchText) ||
                    movement.type.toLowerCase().includes(searchText) ||
                    movement.quantite.toString().includes(searchText) ||
                    movement.date.toLowerCase().includes(searchText) ||
                    movement.commentaire.toLowerCase().includes(searchText)
                );
            });

            filteredMovements.forEach((movement, index) => {
                const row = document.createElement('tr');
                row.classList.add('border-b');
                row.innerHTML = `
                <td class="p-2">${movement.id_produit}</td>
                <td class="p-2">${movement.type}</td>
                <td class="p-2">${movement.quantite}</td>
                <td class="p-2">${new Date(movement.date).toLocaleString('fr-FR')}</td>
                <td class="p-2">${movement.commentaire}</td>
                <td class="p-2">
                    <a href="#" class="text-blue-600 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                    <button class="text-red-600 hover:underline" onclick="confirm('Voulez-vous vraiment supprimer ce mouvement ?')"><i class="fas fa-trash"></i></button>
                </td>
            `;
                movementsBody.appendChild(row);
            });
        }

        // Ajout des IDs et écouteurs pour les barres de recherche
        searchHeader.addEventListener('input', () => renderMovements(searchHeader.value));
        searchSidebar.addEventListener('input', () => renderMovements(searchSidebar.value));

        // Affichage initial des mouvements
        renderMovements();

        const totalStock = stocksData.reduce((sum, item) => sum + item.quantite, 0);
        document.getElementById('total-stock').textContent = totalStock;

        Chart.defaults.font.size = 12;

        const movementDistributionData = {
            labels: ['Entrées', 'Sorties'],
            datasets: [{
                label: 'Quantité',
                data: [
                    movementsData.filter(m => m.type === 'Entrée').reduce((sum, m) => sum + m.quantite, 0),
                    movementsData.filter(m => m.type === 'Sortie').reduce((sum, m) => sum + m.quantite, 0)
                ],
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
                    tooltip: { callbacks: { label: context => `${context.label}: ${context.parsed} unités` } }
                }
            }
        });

        const quantityEvolutionData = {
            labels: [...new Set(movementsData.map(m => m.date.split(' ')[0]))],
            datasets: stocksData.map(product => ({
                label: product.nom_produit,
                data: movementsData.filter(m => m.id_produit === product.id_produit).map(m => {
                    return m.type === 'Entrée' ? product.quantite + m.quantite : product.quantite;
                }),
                borderColor: product.id_produit === 1 ? 'rgba(0,153,255,0.6)' : 'rgba(255,185,0,0.6)',
                fill: false
            }))
        };

        new Chart(document.getElementById('quantityEvolutionChart').getContext('2d'), {
            type: 'line',
            data: quantityEvolutionData,
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { callback: value => `${value} unités` } }
                },
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: { callbacks: { label: context => `${context.dataset.label}: ${context.parsed.y} unités` } }
                }
            }
        });
    </script>
</body>

</html>