<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Employé</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts pour une typographie moderne -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Styles personnalisés */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: linear-gradient(45deg, #38d62c 0%, #55deaf 100%);
            color: white;
            padding: 15px 30px;
            box-shadow: 0 4px 15px rgba(56, 214, 44, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .logo {
            font-size: 1.5rem;
            font-weight: 500;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .header .header-buttons {
            display: flex;
            gap: 15px;
        }

        /* Bouton de déconnexion (dans le header) */
        .logout-btn {
            background-color: #55deaf;
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 2px 8px rgba(85, 222, 175, 0.3);
        }

        .logout-btn:hover {
            background-color: #38d62c;
            transform: scale(1.05);
        }

        /* Bouton Retour au tableau de bord */
        .dashboard-btn {
            background-color: #87e8b6;
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 2px 8px rgba(135, 232, 182, 0.3);
        }

        .dashboard-btn:hover {
            background-color: #55deaf;
            transform: scale(1.05);
        }

        /* Bouton Demande de congé */
        .request-leave-btn {
            background-color: #87e8b6; /* Couleur secondaire */
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 2px 8px rgba(135, 232, 182, 0.3);
        }

        .request-leave-btn:hover {
            background-color: #55deaf; /* Couleur tertiaire */
            transform: scale(1.05);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px;
        }

        .profile-header {
            background: linear-gradient(45deg, #38d62c 0%, #55deaf 100%);
            color: white;
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 6px 20px rgba(56, 214, 44, 0.2);
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/white-diamond.png');
            opacity: 0.15;
        }

        .profile-header .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: #38d62c;
            border: 4px solid #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .profile-header .info {
            z-index: 1;
        }

        .profile-header .info h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 500;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .profile-header .info p {
            margin: 5px 0 0;
            font-size: 0.95rem;
            opacity: 0.95;
        }

        .card {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: #fefefe;
            border-bottom: 1px solid #f1f3f5;
            padding: 15px 25px;
            font-size: 1.15rem;
            font-weight: 500;
            color: #2d3436;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .card-header .actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .card-body {
            padding: 25px;
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background-color: #f7f9fb;
            color: #2d3436;
            font-weight: 500;
            padding: 12px 15px;
            border: none;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border: none;
            color: #636e72;
        }

        .table tbody tr {
            transition: background-color 0.3s ease;
            border-bottom: 1px solid #f1f3f5;
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: #f9fbfc;
        }

        .no-data {
            text-align: center;
            color: #b2bec3;
            font-style: italic;
            font-size: 0.9rem;
        }

        .filter-input {
            max-width: 180px;
            padding: 8px 12px;
            border: 1px solid #dfe4ea;
            border-radius: 10px;
            font-size: 0.85rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .filter-input:focus {
            outline: none;
            border-color: #55deaf;
            box-shadow: 0 0 8px rgba(85, 222, 175, 0.2);
        }

        .status-pending {
            color: #f1c40f;
            font-weight: 500;
        }

        .status-approved {
            color: #38d62c;
            font-weight: 500;
        }

        .status-rejected {
            color: #e74c3c;
            font-weight: 500;
        }

        /* Bouton d'édition du profil */
        .edit-btn {
            background-color: #87e8b6;
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .edit-btn:hover {
            background-color: #55deaf;
            transform: scale(1.05);
        }

        /* Section des informations personnelles */
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list li span:first-child {
            font-weight: 500;
            color: #2d3436;
        }

        .info-list li span:last-child {
            color: #636e72;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 10px;
                padding: 10px 20px;
            }

            .header .logo {
                font-size: 1.2rem;
            }

            .header .header-buttons {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .logout-btn, .dashboard-btn, .request-leave-btn {
                padding: 6px 12px;
                font-size: 0.9rem;
                width: 100%;
                text-align: center;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .profile-header .avatar {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
            }

            .profile-header .info h1 {
                font-size: 1.4rem;
            }

            .profile-header .info p {
                font-size: 0.85rem;
            }

            .filter-input {
                max-width: 100%;
                margin-bottom: 10px;
            }

            .card-header .actions {
                flex-direction: column;
                gap: 8px;
                width: 100%;
            }

            .table th, .table td {
                font-size: 0.85rem;
                padding: 8px;
            }

            .edit-btn {
                padding: 6px 12px;
                font-size: 0.9rem;
            }

            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<!-- Header -->
<header class="header">
    <div class="logo">Mon Profil</div>
    <div class="header-buttons">
        <!-- Bouton Retour au tableau de bord -->
        <a href="{{ route('dashboard') }}" class="dashboard-btn">
            <i class="fas fa-tachometer-alt"></i> Tableau de bord
        </a>
        <!-- Bouton de déconnexion -->
        <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </div>
</header>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<div class="container">
    <!-- Section des informations personnelles -->
    <div class="card">
        <div class="card-header">
            <span>Informations personnelles</span>
        </div>
        <div class="card-body">
            <ul class="info-list">
                <li>
                    <span>Nom</span>
                    <span>{{ auth()->user()->username }}</span>
                </li>
                <li>
                    <span>Email</span>
                    <span>{{ auth()->user()->email }}</span>
                </li>
                <li>
                    <span>Date d'inscription</span>
                    <span>{{ auth()->user()->date_creation->format('d/m/Y') }}</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Section des congés -->
    <div class="card">
        <div class="card-header">
            <span>Vos congés</span>
            <div class="actions">
                <input type="text" class="filter-input" id="congeFilter" placeholder="Filtrer par type ou statut...">
            <a href="{{ route('conges.create') }}" class="request-leave-btn">
                    <i class="fas fa-plus"></i> Demande de congé
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($conges->isEmpty())
                <p class="no-data">Vous n'avez aucun congé pour le moment.</p>
            @else
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Type</th>
                        <th>Statut</th>
                    </tr>
                    </thead>
                    <tbody id="congeTableBody">
                    @foreach($conges as $conge)
                        <tr>
                            <td>{{ $conge->date_debut }}</td>
                            <td>{{ $conge->date_fin }}</td>
                            <td>{{ $conge->type_conge }}</td>
                            <td class="status-{{ strtolower($conge->statut) }}">{{ $conge->statut }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Section des salaires -->
    <div class="card">
        <div class="card-header">
            <span>Vos salaires</span>
            <div class="actions">
                <input type="text" class="filter-input" id="salaireFilter" placeholder="Filtrer par date...">
            </div>
        </div>
        <div class="card-body">
            @if($salaires->isEmpty())
                <p class="no-data">Vous n'avez aucun salaire enregistré pour le moment.</p>
            @else
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Montant</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                    </tr>
                    </thead>
                    <tbody id="salaireTableBody">
                    @foreach($salaires as $salaire)
                        <tr>
                            <td>{{ $salaire->montant }} €</td>
                            <td>{{ $salaire->date_debut }}</td>
                            <td>{{ $salaire->date_fin }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<!-- Bootstrap JS et Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- JavaScript personnalisé -->
<script>
    // Filtrer les congés
    document.getElementById('congeFilter').addEventListener('input', function(e) {
        const filter = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#congeTableBody tr');

        rows.forEach(row => {
            const type = row.cells[2].textContent.toLowerCase();
            const statut = row.cells[3].textContent.toLowerCase();

            if (type.includes(filter) || statut.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Filtrer les salaires
    document.getElementById('salaireFilter').addEventListener('input', function(e) {
        const filter = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#salaireTableBody tr');

        rows.forEach(row => {
            const dateDebut = row.cells[1].textContent.toLowerCase();
            const dateFin = row.cells[2].textContent.toLowerCase();

            if (dateDebut.includes(filter) || dateFin.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Animation d'apparition des cartes
    document.querySelectorAll('.card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Animation de l'en-tête
    const profileHeader = document.querySelector('.profile-header');
    profileHeader.style.opacity = '0';
    profileHeader.style.transform = 'translateY(-20px)';
    setTimeout(() => {
        profileHeader.style.transition = 'all 0.5s ease';
        profileHeader.style.opacity = '1';
        profileHeader.style.transform = 'translateY(0)';
    }, 100);
</script>
</body>
</html>