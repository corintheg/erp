<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f0f2f5;
            color: #333;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        .header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #777;
        }
        .main-content {
            display: flex;
            gap: 30px;
        }
        .personal-info {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .personal-info h2 {
            font-size: 20px;
            color: #007bff;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }
        .personal-info p {
            margin-bottom: 10px;
        }
        .personal-info p strong {
            color: #555;
        }
        .leaves-section {
            flex: 2;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .leaves-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .leaves-header h2 {
            font-size: 20px;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }
        .leaves-header .btn {
            background-color: #007bff;
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .leaves-header .btn:hover {
            background-color: #0056b3;
        }
        .filter {
            margin-bottom: 15px;
        }
        .filter select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .leaves-table {
            width: 100%;
            border-collapse: collapse;
        }
        .leaves-table th,
        .leaves-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .leaves-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .leaves-table .badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            color: #fff;
        }
        .leaves-table .badge.approved {
            background-color: #28a745;
        }
        .leaves-table .badge.pending {
            background-color: #ffc107;
            color: #333;
        }
        .leaves-table .badge.rejected {
            background-color: #dc3545;
        }
        .leaves-table .btn-view {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .leaves-table .btn-view:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }
            .header img {
                width: 60px;
                height: 60px;
            }
            .header h1 {
                font-size: 20px;
            }
            .leaves-table th,
            .leaves-table td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- En-tête -->
    <div class="header">
        <img src="https://via.placeholder.com/80" alt="Avatar">
        <div>
            <h1>Bonjour, {{ Auth::user()->username }}</h1>
            <p>{{ Auth::user()->email }}</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <!-- Informations personnelles -->
        <div class="personal-info">
            <h2>Informations personnelles</h2>
            <p><strong>Nom d'utilisateur :</strong> {{ Auth::user()->username }}</p>
            <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
            <p><strong>Rôle :</strong>
                @foreach (Auth::user()->roles as $role)
                    {{ $role->nom_role }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </p>
        </div>

        <!-- Section congés -->
        <div class="leaves-section">
            <div class="leaves-header">
                <h2>Mes congés</h2>
                <a href="/leave_request" class="btn">Demander un congé</a>
            </div>

            <!-- Filtre -->
            <div class="filter">
                <select id="filtreStatut">
                    <option value="">Tous les statuts</option>
                    <option value="approuve">Approuvé</option>
                    <option value="en_attente">En attente</option>
                    <option value="refuse">Refusé</option>
                </select>
            </div>

            <!-- Tableau des congés -->
            <table class="leaves-table">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Statut</th>
                    <th>Commentaires</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($conges as $conge)
                    <tr>
                        <td>{{ $conge->type_conge }}</td>
                        <td>{{ $conge->date_debut }}</td>
                        <td>{{ $conge->date_fin }}</td>
                        <td>
                                <span class="badge {{ $conge->statut == 'approuve' ? 'approved' : ($conge->statut == 'en_attente' ? 'pending' : 'rejected') }}">
                                    {{ ucfirst($conge->statut) }}
                                </span>
                        </td>
                        <td>{{ $conge->commentaires ?? 'Aucun' }}</td>
                        <td><a href="#" class="btn-view">Voir</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Aucun congé trouvé.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('filtreStatut').addEventListener('change', function() {
        const statut = this.value;
        const rows = document.querySelectorAll('.leaves-table tbody tr');
        rows.forEach(row => {
            const statutCell = row.querySelector('.badge').textContent.toLowerCase();
            row.style.display = (statut === '' || statutCell === statut) ? '' : 'none';
        });
    });
</script>
</body>
</html>