<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès refusé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">
    <div class="container text-center mt-5">
        <h1 class="display-4 text-danger">419 - Session expirée</h1>
        <p class="lead mb-4">Votre session n'est plus valable, veuillez vous reconnecter.</p>


        <a href="{{ route('dashboard') }}" class="btn btn-danger ">
            Retour à l'accueil
        </a>
    </div>
</body>

</html>