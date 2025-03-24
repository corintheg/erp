<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Fournisseur</title>
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
        <h2 class="mb-4">Enregistrement d’un nouveau fournisseur</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fournisseurs.store') }}" method="POST" class="card p-4">
            @csrf

            <div class="mb-3">
                <label for="nom" class="form-label">Nom du fournisseur</label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom') }}" required>
            </div>

            <div class="mb-3">
                <label for="contact" class="form-label">Nom du contact</label>
                <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact') }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') }}">
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <textarea class="form-control" id="adresse" name="adresse" rows="2">{{ old('adresse') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="site_web" class="form-label">Site Web</label>
                <input type="text" class="form-control" id="site_web" name="site_web" value="{{ old('site_web') }}">
            </div>

            <button type="submit" class="btn btn-custom">Enregistrer le fournisseur</button>
            <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary ">Annuler</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>