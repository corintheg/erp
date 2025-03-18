<?php
$host = "localhost";
$dbname = "erp";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion réussie à la base de données.<br><br>";
    $tables = ['users', 'salaires', 'conges', 'absences', 'stocks', 'fournisseurs', 'livraisons', 'plannings', 'documents'];

    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Table <b>$table</b> trouvée.<br>";
        } else {
            echo "❌ Table <b>$table</b> manquante !<br>";
        }
    }

} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}
?>

<?php
// Paramètres de connexion
$host = "localhost";  // Modifier si nécessaire
$dbname = "erp"; // Nom de la base de données
$username = "root";   // Modifier selon ton utilisateur
$password = "";       // Modifier si nécessaire

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h2>✅ Connexion réussie à la base de données.</h2>";

    // Tables à vérifier
    $tables = ['users', 'employes', 'salaires', 'conges', 'absences', 'transactions', 'stocks', 'fournisseurs', 'livraisons', 'plannings', 'documents'];

    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<h3>✅ Table <b>$table</b> trouvée.</h3>";

            // Récupération du contenu
            $dataStmt = $pdo->query("SELECT * FROM $table");
            $rows = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($rows) > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<tr>";

                // En-têtes de colonnes
                foreach (array_keys($rows[0]) as $col) {
                    echo "<th>$col</th>";
                }
                echo "</tr>";

                // Affichage des données
                foreach ($rows as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }
                echo "</table><br>";
            } else {
                echo "⚠️ Aucune donnée dans la table <b>$table</b>.<br>";
            }

        } else {
            echo "<h3>❌ Table <b>$table</b> manquante !</h3>";
        }
    }

} catch (PDOException $e) {
    die("<h2>❌ Erreur de connexion :</h2> " . $e->getMessage());
}
?>

<?php
// Paramètres de connexion
$host = "localhost";  // Modifier si nécessaire
$dbname = "erp"; // Nom de la base de données
$username = "root";   // Modifier selon ton utilisateur
$password = "";       // Modifier si nécessaire

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<h2>❌ Erreur de connexion :</h2> " . $e->getMessage());
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_employe = $_POST["id_employe"];
    $type_conge = $_POST["type_conge"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    $statut = $_POST["statut"];
    $commentaires = $_POST["commentaires"];

    try {
        // Requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO conges (id_employe, type_conge, date_debut, date_fin, statut, commentaires)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_employe, $type_conge, $date_debut, $date_fin, $statut, $commentaires]);

        echo "<p style='color: green;'>✅ Congé ajouté avec succès !</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>❌ Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

        <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Congé</title>
</head>
<body>
<h2>Ajouter un Congé</h2>
<form action="" method="post">
    <label for="id_employe">ID Employé :</label>
    <input type="number" name="id_employe" required><br><br>

    <label for="type_conge">Type de congé :</label>
    <input type="text" name="type_conge" required><br><br>

    <label for="date_debut">Date début :</label>
    <input type="date" name="date_debut" required><br><br>

    <label for="date_fin">Date fin :</label>
    <input type="date" name="date_fin" required><br><br>

    <label for="statut">Statut :</label>
    <select name="statut" required>
        <option value="En attente">En attente</option>
        <option value="Approuvé">Approuvé</option>
        <option value="Rejeté">Rejeté</option>
    </select><br><br>

    <label for="commentaires">Commentaires :</label>
    <textarea name="commentaires"></textarea><br><br>

    <button type="submit">Ajouter</button>
</form>
</body>
</html>

