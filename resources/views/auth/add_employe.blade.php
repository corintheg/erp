<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Enregistrement | ERP</title>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <form action="/add_employe" method="POST" class="w-full max-w-md md:max-w-lg lg:max-w-xl mx-auto p-6 bg-white rounded-lg shadow-md animate-fade-in">
            @csrf
            <div class="mb-4 animate-slide-up" style="animation-delay: 0.1s;">
                <input
                        type="text"
                        name="nom"
                        id="nom"
                        placeholder="Nom"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                >
            </div>

            <div class="mb-4 animate-slide-up" style="animation-delay: 0.2s;">
                <input
                        type="text"
                        name="prenom"
                        id="prenom"
                        placeholder="Prénom"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                >
            </div>

            <div class="mb-4 animate-slide-up" style="animation-delay: 0.3s;">
                <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                        readonly
                >
            </div>

            <div class="mb-4 animate-slide-up" style="animation-delay: 0.4s;">
                <input
                        type="text"
                        name="telephone"
                        placeholder="Téléphone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                >
            </div>

            <div class="mb-4 animate-slide-up" style="animation-delay: 0.5s;">
                <input
                        type="date"
                        name="date_embauche"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus"
                >
            </div>

            <div class="mb-6 animate-slide-up" style="animation-delay: 0.6s;">
                <select
                        name="departement"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c] focus:border-transparent input-focus bg-white"
                >
                    <option value="" disabled selected>Sélectionner un département</option>
                    <option value="rh">RH</option>
                    <option value="finance">Finance</option>
                    <option value="informatique">Informatique</option>
                    <option value="livraison">Livraison</option>
                </select>
            </div>

            <div class="animate-slide-up" style="animation-delay: 0.7s;">
                <button
                        type="submit"
                        class="w-full bg-[#38d62c] hover:bg-[#87e8b6] text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out button-hover"
                >
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</body>
</html>


<script>
    document.getElementById('nom').addEventListener('input', updateEmail);
    document.getElementById('prenom').addEventListener('input', updateEmail);

    function updateEmail() {
        const nom = document.getElementById('nom').value;
        const prenom = document.getElementById('prenom').value;
        const emailField = document.getElementById('email');

        if (nom && prenom) {
            const email = `${nom.toLowerCase()}.${prenom.toLowerCase()}@erp.fr`;
            emailField.value = email;
        }
    }
</script>