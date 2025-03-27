<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP System - Salaires</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease-in-out; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            #search-bar-header { display: none !important; }
            #search-bar-sidebar { display: block !important; }
        }
        @media (min-width: 769px) { #burger-btn { display: none !important; } }
        #search-bar-sidebar { display: none; }
    </style>
</head>
<body class="bg-gray-100 font-sans flex">
<button id="burger-btn" class="fixed bottom-6 right-6 z-50 p-4 text-white bg-green-600 rounded-full shadow">
    <i class="fas fa-bars text-2xl"></i>
</button>
<aside id="sidebar" class="sidebar w-64 bg-gray-800 text-[#55deaf] h-full fixed">
    <div class="p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">ERP System</h1>
        <button id="close-btn" class="md:hidden text-white"><i class="fas fa-times"></i></button>
    </div>
    <div id="search-bar-sidebar" class="p-4">
        <div class="relative">
            <input type="text" id="search-sidebar" placeholder="Rechercher un salaire..." class="w-full bg-gray-700 text-white border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#55deaf]">
            <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>
    <nav class="mt-6">
        <a href="{{ route('dashboard') }}" class="flex items-center p-4 hover:bg-gray-700"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a>
        <a href="{{ route('inventory') }}" class="flex items-center p-4 hover:bg-gray-700"><i class="fas fa-warehouse mr-3"></i> Inventaire</a>
        <a href="{{ route('hr') }}" class="flex items-center p-4 hover:bg-gray-700"><i class="fas fa-users mr-3"></i> Ressources Humaines</a>
        <a href="{{ route('salaries.index') }}" class="flex items-center p-4 bg-gray-700"><i class="fas fa-chart-line mr-3"></i> Finances</a>
        <a href="{{ route('settings') }}" class="flex items-center p-4 hover:bg-gray-700"><i class="fas fa-cog mr-3"></i> Paramètres</a>
    </nav>
    <div class="absolute bottom-0 p-4">
        <a href="{{ route('logout') }}" class="flex items-center text-red-500 hover:text-red-400"><i class="fas fa-sign-out-alt mr-3"></i> Déconnexion</a>
    </div>
</aside>
<main class="main-content flex-1 ml-64 p-6">
    <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Salaires</h2>
        <div class="flex items-center space-x-4">
            <div id="search-bar-header" class="relative">
                <input type="text" id="search-header" placeholder="Rechercher un salaire..." class="border rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <div class="flex items-center">
                <i class="fas fa-user-circle text-2xl mr-2"></i>
                <span>{{ Auth::user()->name ?? 'Admin User' }}</span>
            </div>
        </div>
    </header>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Liste des Salaires</h3>
                <a href="{{ route('salaries.create') }}" class="text-blue-600 hover:underline text-sm">Ajouter un salaire</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="salaries-table">
                    <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 text-left">Employé</th>
                        <th class="p-2 text-left">Montant (€)</th>
                        <th class="p-2 text-left">Date Début</th>
                        <th class="p-2 text-left">Date Fin</th>
                        <th class="p-2 text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="salaries-body">
                    @foreach ($salaries as $salaire)
                    <tr class="border-b">
                        <td class="p-2">{{ $salaire->employe ? $salaire->employe->nom : 'Inconnu' }}</td>
                        <td class="p-2">{{ number_format($salaire->montant, 2, ',', ' ') }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($salaire->date_debut)->format('d/m/Y') }}</td>
                        <td class="p-2">{{ $salaire->date_fin ? \Carbon\Carbon::parse($salaire->date_fin)->format('d/m/Y') : '-' }}</td>
                        <td class="p-2">
                            <a href="{{ route('salaries.edit', $salaire->id_salaire) }}" class="text-blue-600 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('salaries.delete', $salaire->id_salaire) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Voulez-vous vraiment supprimer ce salaire ?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Répartition des Salaires</h3>
            <canvas id="salaryDistributionChart" height="150"></canvas>
        </div>
        <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
            <h3 class="text-lg font-medium mb-4">Évolution des Salaires</h3>
            <canvas id="salaryEvolutionChart" height="150"></canvas>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Total des Salaires</h3>
            <p class="text-2xl font-bold text-green-600" id="total-salaries">{{ number_format($totalSalaries, 2, ',', ' ') }} €</p>
            <p class="text-sm text-gray-500">Masse salariale actuelle</p>
        </div>
    </div>
</main>

<script>
    // Gestion de la sidebar
    const sidebar = document.getElementById('sidebar');
    const burgerBtn = document.getElementById('burger-btn');
    const closeBtn = document.getElementById('close-btn');

    burgerBtn.addEventListener('click', () => sidebar.classList.add('open'));
    closeBtn.addEventListener('click', () => sidebar.classList.remove('open'));
    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !burgerBtn.contains(e.target) && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
        }
    });

    // Gestion des barres de recherche avec AJAX
    const searchHeader = document.getElementById('search-header');
    const searchSidebar = document.getElementById('search-sidebar');
    const salariesBody = document.getElementById('salaries-body');
    const totalSalariesElement = document.getElementById('total-salaries');
    let distributionChart, evolutionChart;

    async function fetchSalaries(query = '') {
        const response = await fetch(`/salaries?search=${encodeURIComponent(query)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();

        // Mise à jour du tableau
        salariesBody.innerHTML = data.salaries.map(salaire => `
            <tr class="border-b">
                <td class="p-2">${salaire.employe ? salaire.employe.nom : 'Inconnu'}</td>
                <td class="p-2">${new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(salaire.montant)}</td>
                <td class="p-2">${new Date(salaire.date_debut).toLocaleDateString('fr-FR')}</td>
                <td class="p-2">${salaire.date_fin ? new Date(salaire.date_fin).toLocaleDateString('fr-FR') : '-'}</td>
                <td class="p-2">
                    <a href="/salaries/${salaire.id_salaire}/edit" class="text-blue-600 hover:underline mr-2"><i class="fas fa-edit"></i></a>
                    <form action="/salaries/${salaire.id_salaire}" method="POST" class="inline">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Voulez-vous vraiment supprimer ce salaire ?')"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        `).join('');

        // Mise à jour du total
        totalSalariesElement.textContent = `${new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(data.totalSalaries)} €`;

        // Mise à jour des graphiques
        updateCharts(data);
    }

    function updateCharts(data) {
        // Répartition des Salaires
        if (distributionChart) distributionChart.destroy();
        distributionChart = new Chart(document.getElementById('salaryDistributionChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: Object.keys(data.salaryDistribution),
                datasets: [{
                    label: 'Montant (€)',
                    data: Object.values(data.salaryDistribution),
                    backgroundColor: ['rgba(0,153,255,0.6)', 'rgba(255,185,0,0.6)', 'rgba(25,255,0,0.6)', 'rgba(255,0,55,0.6)'],
                    borderColor: ['rgba(0,153,255,0.6)', 'rgba(255,185,0,0.6)', 'rgba(25,255,0,0.6)', 'rgba(255,0,55,0.6)'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12 } },
                    tooltip: { callbacks: { label: context => `${context.label}: ${new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(context.parsed)}` } }
                }
            }
        });

        // Évolution des Salaires (simplifiée ici)
        if (evolutionChart) evolutionChart.destroy();
        evolutionChart = new Chart(document.getElementById('salaryEvolutionChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: [...new Set(data.salaries.map(s => s.date_debut))],
                datasets: Object.keys(data.salaryDistribution).map((nom, i) => ({
                    label: nom,
                    data: data.salaries.filter(s => s.employe && s.employe.nom === nom).map(s => s.montant),
                    borderColor: `rgba(${i * 50}, ${255 - i * 50}, ${i * 100}, 0.6)`,
                    fill: false
                }))
            },
            options: {
                scales: { y: { beginAtZero: true, ticks: { callback: value => new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(value) } } },
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: { callbacks: { label: context => `${context.dataset.label}: ${new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(context.parsed.y)}` } }
                }
            }
        });
    }

    // Écouteurs pour les barres de recherche
    searchHeader.addEventListener('input', () => fetchSalaries(searchHeader.value));
    searchSidebar.addEventListener('input', () => fetchSalaries(searchSidebar.value));

    // Chargement initial
    fetchSalaries();
</script>
</body>
</html>

