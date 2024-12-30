<?php

include 'includes/header.php';

$id_employe = $_SESSION['id_employe'];

?>
<h1 class="bulletins-h1">Mes bulletins de paie</h1>

<div class="bulletins-filter-section">
    <form method="GET" action="">
        <label class="bulletins-label" for="mois">Mois :</label>
        <input class="bulletins-input" type="text" id="mois" name="mois" placeholder="Janvier">
        <label class="bulletins-label" for="annee">Année :</label>
        <input class="bulletins-input" type="text" id="annee" name="annee" placeholder="2024">
        <button type="submit">Rechercher</button>
    </form>
</div>

<?php

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
echo `<table class="bulletins-table" border='1'>`;
echo "<tr><th class=`bulletins-th`>ID Fiche</th><th class=`bulletins-th`>Date Fiche</th><th class=`bulletins-th`>Lien</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $idFiche = htmlspecialchars($row['id_fiche'] ?? 'non définie');
    $dateFiche = date('d/m/Y', strtotime($row['date_fiche']));
    $lien = "includes/genereFichePaie2.php?id=$id_employe&fiche=$idFiche";

    echo "<tr>";
    echo "<td class= `bulletins-td`>$idFiche</td>";
    echo "<td class= `bulletins-td`>$dateFiche</td>";
    echo "<td class= `bulletins-td`><a class = `bulletins-a`href='$lien' target='_blank'>Générer</a></td>";
    echo "</tr>";
}

echo "</table>";

?>

<?php
include 'includes/footer.php';
?>