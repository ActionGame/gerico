<?php
include "../includes/header.php";
?>


<?php
$stmt = $pdo->prepare('SELECT demande_de_congés.etat_demande AS etat_demande, demande_de_congés.id_conge AS id, motif_demande AS motif, employés.nom_employe AS nom, employés.prenom_employe AS prenom, date_debut, date_fin FROM demande_de_congés, employés WHERE demande_de_congés.id_employe = employés.id_employe');
$stmt->execute();

// Récupération de toutes les lignes
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($resultats as $resultat) {
    // Déterminer la classe CSS selon le statut
    $class = "calendar-manage-rounded-rectangle";
    if ($resultat['etat_demande'] === 'validé') {
        $class .= " validated";
    } elseif ($resultat['etat_demande'] === 'refusé') {
        $class .= " refused";
    }
?>
    <div class="<?php echo $class; ?>" id="demande-<?php echo htmlspecialchars($resultat['id']); ?>">
        <?php echo htmlspecialchars($resultat['nom']) . " " . htmlspecialchars($resultat['prenom']) . " demande un congé du " . htmlspecialchars($resultat['date_debut']) . " au " . htmlspecialchars($resultat['date_fin']) . " pour le motif suivant : " . htmlspecialchars($resultat['motif']); ?>
        <form method="POST" action="valider_demande.php" style="display:inline;">
            <input type="hidden" name="id_conge" value="<?php echo htmlspecialchars($resultat['id']); ?>">
            <button type="submit" class="validate-btn">Valider</button>
        </form>
        <form method="POST" action="refuser_demande.php" style="display:inline;">
            <input type="hidden" name="id_conge" value="<?php echo htmlspecialchars($resultat['id']); ?>">
            <button type="submit" class="refuse-btn">Refuser</button>
        </form>
    </div>
<?php } ?>

<?php
include "../includes/footer.php";
?>