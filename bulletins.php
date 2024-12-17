<?php

include 'includes/header.php';

$id_employe = $_SESSION['id_employe'];

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/bulletins.css">
    <title>Mes bulletins de paie</title>
</head>

<body>

    <h1>Mes bulletins de paie</h1>

    <div class="filter-section">
        <form method="GET" action="">
            <label for="mois">Mois :</label>
            <input type="text" id="mois" name="mois" placeholder="Janvier">
            <label for="annee">Année :</label>
            <input type="text" id="annee" name="annee" placeholder="2024">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <?php
    // Connexion à la base de données
    $host = 'localhost'; // Nom de l’hôte
    $dbname = 'gerico'; // Nom de la base de données
    $user = 'root'; // Utilisateur de la base de données
    $password = ''; // Mot de passe

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Récupération des paramètres de filtre
    $mois = isset($_GET['mois']) ? $_GET['mois'] : '';
    $annee = isset($_GET['annee']) ? $_GET['annee'] : '';

    // Préparation de la requête avec filtres
    $sql = "SELECT id_fiche, date_fiche FROM fiche_de_paie WHERE id_employe = :id";

    $params = [':id' => $id_employe];

    if (!empty($mois) || !empty($annee)) {
        $sql .= " AND date_fiche LIKE :dateFilter";
        $dateFilter = "%";

        if (!empty($annee)) {
            $dateFilter = $annee . "-%";
        }

        if (!empty($mois)) {
            $moisNumerique = str_pad(array_search(strtolower($mois), array_map('strtolower', ["", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"])), 2, "0", STR_PAD_LEFT);
            $dateFilter = (!empty($annee) ? $annee : "____") . "-" . $moisNumerique . "-%";
        }

        $params[':dateFilter'] = $dateFilter;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Affichage des résultats dans un tableau HTML
    echo "<table border='1'>";
    echo "<tr><th>ID Fiche</th><th>Date Fiche</th><th>Lien</th></tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $idFiche = htmlspecialchars($row['id_fiche'] ?? 'non définie');
        $dateFiche = date('d/m/Y', strtotime($row['date_fiche']));
        $lien = "includes/genereFichePaie2.php?id=$id_employe&fiche=$idFiche";

        echo "<tr>";
        echo "<td>$idFiche</td>";
        echo "<td>$dateFiche</td>";
        echo "<td><a href='$lien' target='_blank'>Générer</a></td>";
        echo "</tr>";
    }

    echo "</table>";

    ?>

</body>

</html>
<?php
include 'includes/footer.php';
?>