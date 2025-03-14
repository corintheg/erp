<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS via CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        /* Petite personnalisation pour activer le backdrop-blur sur certains navigateurs */
        .backdrop-blur {
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#38d62c] to-[##55deaf] flex items-center justify-center">
    <div class="bg-white bg-opacity-90 backdrop-blur p-10 rounded-xl shadow-2xl w-full max-w-md">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Bienvenue</h1>
            <p class="text-gray-600 mt-2">Connectez-vous pour continuer</p>
        </div>
        <form method="POST" action="">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Adresse Email</label>
                <input type="email" name="email" id="email" placeholder="Votre email" required autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Votre mot de passe" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
            </div>
            <button type="submit"
                class="w-full py-3 bg-[#38d62c] text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition duration-300 cursor-pointer ">Se
                connecter</button>
        </form>

    </div>
</body>

</html>