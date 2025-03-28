<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP System - Modifier un Salaire</title>
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
        <h2 class="text-2xl font-semibold">Modifier un Salaire</h2>
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <i class="fas fa-user-circle text-2xl mr-2"></i>
                <span>{{ Auth::user()->username }}</span>
            </div>
        </div>
    </header>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium mb-4">Détails du Salaire</h3>
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('salaries.update', $salaire->id_salaire) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="id_employe" class="block text-sm font-medium text-gray-700">Employé</label>
                <select id="id_employe" name="id_employe" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @foreach ($employes as $employe)
                        <option value="{{ $employe->id_employe }}" {{ $salaire->id_employe == $employe->id_employe ? 'selected' : '' }}>
                            {{ $employe->nom }} {{ $employe->prenom }}
                        </option>
                    @endforeach
                </select>
                @error('id_employe')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="montant" class="block text-sm font-medium text-gray-700">Montant (€)</label>
                <input type="number" step="0.01" id="montant" name="montant" value="{{ $salaire->montant }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('montant')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de Début</label>
                <input type="date" id="date_debut" name="date_debut" value="{{ $salaire->date_debut }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('date_debut')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de Fin (optionnel)</label>
                <input type="date" id="date_fin" name="date_fin" value="{{ $salaire->date_fin }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('date_fin')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('salaries.index') }}" class="text-gray-600 hover:underline">Annuler</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Mettre à jour</button>
            </div>
        </form>
    </div>
</main>

<script>
    // Gestion de la sidebar (identique à la page index)
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
</script>
</body>
</html>