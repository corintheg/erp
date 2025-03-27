<!-- resources/views/conges/create.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de congé</title>
    <!-- Inclusion de Bootstrap pour un design simple -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            background-color: #38d62c;
            border-color: #38d62c;
            color: white;
        }
        .btn-custom:hover {
            background-color: #2fb724;
            border-color: #2fb724;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Nouvelle demande de congé</h2>

    <!-- Affichage des erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/leave_request" method="POST" class="card p-4">
        @csrf

        <!-- Champ caché pour l'ID de l'utilisateur -->
        <input type="hidden" name="user_id" value="{{ Auth::user()->id_utilisateur }}">

        <!-- Type de congé -->
        <div class="mb-3">
            <label for="type_conge" class="form-label">Type de congé</label>
            <select class="form-select" id="type_conge" name="type_conge" required>
                <option value="">Sélectionnez un type</option>
                <option value="RTT">RTT</option>
                <option value="CP">Congés Payés (CP)</option>
                <option value="Maladie">Maladie</option>
            </select>
        </div>

        <!-- Date de début -->
        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut"
                   value="{{ old('date_debut') }}" required>
        </div>

        <!-- Date de fin -->
        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin"
                   value="{{ old('date_fin') }}" required>
        </div>

        <!-- Raison -->
        <div class="mb-3">
            <label for="raison" class="form-label">Raison</label>
            <textarea class="form-control" id="raison" name="raison" rows="3"
                      placeholder="Expliquez la raison de votre demande">{{ old('raison') }}</textarea>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-custom" id="submitButton">Soumettre la demande</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const typeCongeSelect = document.getElementById('type_conge');
    const submitButton = document.getElementById('submitButton');

    typeCongeSelect.addEventListener('change', function() {
        if (this.value === 'Maladie') {
            submitButton.textContent = 'Envoyer le congé';
        } else {
            submitButton.textContent = 'Soumettre la demande';
        }
    });
</script>
</body>
</html>