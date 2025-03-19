<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Base de Données</title>
</head>
<body>
<h2>{{ $message }}</h2>

@foreach ($tablesData as $table => $data)
    @if (is_null($data))
        <h3>❌ Table <b>{{ $table }}</b> manquante !</h3>
    @else
        <h3>✅ Table <b>{{ $table }}</b> trouvée.</h3>
        @if ($data->isEmpty())
            <p>⚠️ Aucune donnée dans la table <b>{{ $table }}</b>.</p>
        @else
            <table>
                <tr>
                    @foreach ($data[0] as $key => $value)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
                @foreach ($data as $row)
                    <tr>
                        @foreach ($row as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        @endif
    @endif
@endforeach
</body>
</html>
