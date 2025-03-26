<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini ERP - Tech Gestion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-sans">
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Mini ERP</h1>
            <div class="space-x-4">
                <a href="#employes" class="hover:underline">Employés</a>
                <a href="#finances" class="hover:underline">Finances</a>
                <a href="#stocks" class="hover:underline">Stocks</a>
                <a href="#documents" class="hover:underline">Documents</a>
                <a href="#reporting" class="hover:underline">Reporting</a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Se déconnecter</button>
            </form>
        </div>
    </nav>
    <div class="container mx-auto mt-6 p-4">
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Tableau de bord</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium">Statistiques Employés</h3>
                    <canvas id="employeeChart" class="w-full h-64"></canvas>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium">Revenus/Dépenses</h3>
                    <canvas id="financeChart" class="w-full h-64"></canvas>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium">Niveau des stocks</h3>
                    <canvas id="stockChart" class="w-full h-64"></canvas>
                </div>
            </div>
        </section>
    </div>

    <script>
        async function fetchData(url) {
            try {
                const response = await fetch(url, {
                    headers: { 'Authorization': 'Bearer VOTRE_JETON_SANCTUM' }
                });
                return await response.json();
            } catch (error) {
                console.error('Erreur lors de la récupération des données:', error);
                return null;
            }
        }

        async function renderCharts() {
            const employeStats = await fetchData('http://127.0.0.1:8000/api/statistiques/employes');
            const financeStats = await fetchData('http://127.0.0.1:8000/api/statistiques/finances');
            const stockStats = await fetchData('http://127.0.0.1:8000/api/statistiques/stocks');

            if (!employeStats || !financeStats || !stockStats) {
                console.error("Impossible de charger les données.");
                return;
            }

            new Chart(document.getElementById('employeeChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: employeStats.labels,
                    datasets: [{
                        label: 'Nombre d\'employés',
                        data: employeStats.data,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    }]
                },
            });

            new Chart(document.getElementById('financeChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Revenus', 'Dépenses'],
                    datasets: [{
                        data: [financeStats.revenus, financeStats.depenses],
                        backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                    }]
                },
            });

            new Chart(document.getElementById('stockChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: stockStats.labels,
                    datasets: [{
                        label: 'Niveau de stock',
                        data: stockStats.data,
                        borderColor: 'rgba(153, 102, 255, 0.6)',
                        fill: false,
                    }]
                },
            });
        }

        document.addEventListener('DOMContentLoaded', renderCharts);
    </script>
</body>

</html>