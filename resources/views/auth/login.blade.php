<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .backdrop-blur {
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#38d62c] to-[#55deaf] flex items-center justify-center">

    <div id="splash-screen"
        class="fixed inset-0 flex items-center justify-center bg-black text-white text-4xl font-bold z-50">
        Application pour ordinateurs (non responsive)
    </div>

    <div id="main-content" class="hidden w-full flex items-center justify-center">
        <div class="bg-white bg-opacity-90 backdrop-blur p-10 rounded-xl shadow-2xl w-full max-w-md">
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Bienvenue</h1>
                <p class="text-gray-600 mt-2">Connectez-vous pour continuer</p>
            </div>

            @if (session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="color: red;">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="color: red;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                    <input type="text" name="username" id="username" placeholder="Votre username" required autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#38d62c]"
                        value="superadmin">
                </div>
                <div class="mb-6">
                    <label for="mot_de_passe" class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                    <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Votre mot de passe"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#38d62c]"
                        value="superadmin">
                </div>
                <button type="submit"
                    class="w-full py-3 bg-[#38d62c] text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition duration-300 cursor-pointer">Se
                    connecter</button>
            </form>

            <!-- Bouton de test utilisateur -->
            <div class="mt-8 text-center">
                <button onclick="remplirUser()"
                    class="inline-flex items-center gap-2 text-white bg-gray-500 px-6 py-3 rounded-lg shadow-lg text-base font-semibold hover:bg-gray-700 cursor-pointer transition duration-300">
                    <i class="fas fa-user"></i> Utiliser un compte utilisateur test
                </button>
            </div>
        </div>
    </div>

    <script>
        function remplirUser() {
            document.getElementById('username').value = 'paul';
            document.getElementById('mot_de_passe').value = 'paul';
        }

        // Affiche la page après 2 secondes
        setTimeout(() => {
            document.getElementById('splash-screen').style.display = 'none';
            document.getElementById('main-content').classList.remove('hidden');
        }, 3000);
    </script>
</body>

</html>