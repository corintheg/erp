<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Gestion des Employés | ERP</title>
</head>
<body class="bg-gray-100">
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Gestion des Employés</h1>

        <!-- Message de succès -->
        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tableau des employés -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Barre de recherche -->
            <div class="mb-4 flex flex-col sm:flex-row gap-4">
                <input
                        type="text"
                        id="searchInput"
                        placeholder="Rechercher par nom..."
                        class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#38d62c]"
                >
            </div>

            <!-- Tableau -->
            <div class="overflow-x-auto">
                <table class="w-full text-left" id="employeeTable">
                    <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-700">Nom</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Prénom</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Département</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Date d'embauche</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Date de débauche</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="employeeList">
                    @forelse ($employes as $employe)
                        <tr class="border-b hover:bg-gray-50 employee-item" data-nom="{{ $employe->nom }}">
                            <td class="px-4 py-3">{{ $employe->nom }}</td>
                            <td class="px-4 py-3">{{ $employe->prenom }}</td>
                            <td class="px-4 py-3">{{ $employe->email }}</td>
                            <td class="px-4 py-3">{{ $employe->departement }}</td>
                            <td class="px-4 py-3">{{ $employe->date_embauche }}</td>
                            <td class="px-4 py-3">{{ $employe->date_debauche ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <button
                                        onclick="openEditModal('{{ $employe->id_employe }}', '{{ $employe->nom }}', '{{ $employe->prenom }}', '{{ $employe->email }}', '{{ $employe->departement }}', '{{ $employe->date_embauche }}', '{{ $employe->date_debauche ?? '' }}')"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200"
                                >
                                    Modifier
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Aucun employé trouvé.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal pour modifier un employé -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Modifier un employé</h2>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_employe" id="editId">
                <div class="mb-4">
                    <label for="editNom" class="block text-gray-700">Nom</label>
                    <input type="text" name="nom" id="editNom" class="w-full px-4 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="editPrenom" class="block text-gray-700">Prénom</label>
                    <input type="text" name="prenom" id="editPrenom" class="w-full px-4 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="editEmail" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="editEmail" class="w-full px-4 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="editDepartement" class="block text-gray-700">Département</label>
                    <select name="departement" id="editDepartement" class="w-full px-4 py-2 border rounded-md">
                        <option value="rh">RH</option>
                        <option value="finance">Finance</option>
                        <option value="informatique">Informatique</option>
                        <option value="livraison">Livraison</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="editDateEmbauche" class="block text-gray-700">Date d'embauche</label>
                    <input type="date" name="date_embauche" id="editDateEmbauche" class="w-full px-4 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="editDateDebauche" class="block text-gray-700">Date de débauche</label>
                    <input type="date" name="date_debauche" id="editDateDebauche" class="w-full px-4 py-2 border rounded-md">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-[#38d62c] text-white rounded-md hover:bg-[#87e8b6]">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    console.log('Page chargée. Nombre d\'employés :', document.querySelectorAll('.employee-item').length);

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const employees = document.querySelectorAll('.employee-item');
            console.log('Recherche pour :', searchTerm);

            employees.forEach(employee => {
                const nom = employee.getAttribute('data-nom').toLowerCase();
                employee.style.display = nom.includes(searchTerm) ? '' : 'none';
            });
        });
    } else {
        console.error("Barre de recherche 'searchInput' non trouvée.");
    }

    function openEditModal(id, nom, prenom, email, departement, dateEmbauche, dateDebauche) {
        console.log('Ouverture du modal pour ID :', id);
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');

        if (modal && form) {
            modal.classList.remove('hidden');
            form.action = `/employes/${id}`;
            document.getElementById('editId').value = id;
            document.getElementById('editNom').value = nom;
            document.getElementById('editPrenom').value = prenom;
            document.getElementById('editEmail').value = email;
            document.getElementById('editDepartement').value = departement;
            document.getElementById('editDateEmbauche').value = dateEmbauche;
            document.getElementById('editDateDebauche').value = dateDebauche || '';
        } else {
            console.error('Modal ou formulaire non trouvé.');
        }
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        if (modal) {
            modal.classList.add('hidden');
        } else {
            console.error('Modal non trouvé pour fermeture.');
        }
    }
</script>
</body>
</html>