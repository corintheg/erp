<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini ERP </title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
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

            /* Barre de recherche dans le header cachée, dans la sidebar visible */
            #search-bar-header {
                display: none !important;
            }

            #search-bar-sidebar {
                display: block !important;
            }
        }

        /* Gestion du bouton burger */
        @media (min-width: 769px) {
            #burger-btn {
                display: none !important;
            }
        }

        /* Par défaut, la barre de recherche dans la sidebar est cachée */
        #search-bar-sidebar {
            display: none;
        }

        .fixed-info {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans flex overflow-x-hidden">

    <!-- Bouton Burger (plus gros, en bas à droite, visible en dessous de 769px) -->
    <button id="burger-btn" class="fixed bottom-6 right-6 z-50 p-4 text-white bg-green-600 rounded-full shadow">
        <i class="fas fa-bars text-2xl"></i>
    </button>

    <!-- Sidebar (hauteur 100%) -->
    <aside id="sidebar" class="sidebar w-64 bg-gray-800 text-green-300 h-full fixed">
        <div class="p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold pt-5">Mini ERP</h1>
            <button id="close-btn" class="md:hidden text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        </div>
        <nav class="mt-6">
            @if ((Auth::user()->hasAnyRole(['superadmin', 'admin'])))
                <a href="{{ route('admin.index') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                    <i class="fa-solid fa-user-tie mr-3"></i> Admin
                </a>
            @endif
            <a href="{{ route('dashboard') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
            <a href="{{ route('user.dashboard') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                <i class="fa-solid fa-plane-departure mr-3"></i>Mon profil
            </a>
            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'rh']))
                <a href="{{ route('employes.index') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                    <i class="fas fa-users mr-3"></i> Employés
                </a>
                <a href="{{ route('conges.index') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                    <i class="fa-solid fa-calendar-days mr-3"></i> Gérer les congés
                </a>
            @endif
            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance', 'rh']))
                <a href="{{ route('salaires.index') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                    <i class="fa-solid fa-dollar-sign mr-3"></i>Salaires
                </a>

            @endif

            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance']))
                <a href="{{ route('finances.index') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                    <i class="fa-solid fa-wallet mr-3"></i> Finances
                </a>

            @endif


            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance', 'livreur', 'manager']))
                <a href="{{ route('fournisseurs.index') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                    <i class="fas fa-tachometer-alt mr-3"></i> Fournisseurs
                </a>
                <a href="{{ route('commandes.index') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                    <i class="fa-solid fa-cart-shopping mr-3"></i> Commandes
                </a>
                <a href="{{ route('stocks.index') }}" class="flex items-center p-4 hover:bg-gray-700 ">
                    <i class="fas fa-warehouse mr-3"></i> Stocks
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center p-4 hover:bg-gray-700 text-red-400 w-full text-left    ">
                    <i class="fa-solid fa-door-open mr-3"></i> Se déconnecter
                </button>
            </form>

        </nav>

    </aside>


    @yield('content')
    <div
        class="fixed-info fixed bottom-6 right-6 bg-white border  border-gray-300 shadow-lg rounded-lg px-5 py-3 text-sm text-gray-700 max-w-xs z-50">
        <i class="fa-solid fa-circle-info text-green-600 mr-2"></i>
        Faites toutes les modifications que vous souhaitez,<br> les données sont réinitialisées toutes les 12h (midi et
        minuit).
    </div>


</body>

</html>