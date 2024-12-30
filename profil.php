<?php
include "includes/header.php";
?>

<div class="profile-container">
    <!-- En-tête du profil -->
    <div class="profile-header">
        <h1><?= htmlspecialchars($_SESSION['prenom_employe']) . " " . htmlspecialchars($_SESSION['nom_employe']); ?></h1>
        <p><?= htmlspecialchars($_SESSION['login']); ?></p>
    </div>

    <!-- Contenu du profil -->
    <div class="profile-content">
        <!-- Section Informations Personnelles -->
        <div class="profile-section">
            <h2>Informations Personnelles</h2>
            <div class="info-grid">
                <div class="info-label">Nom Complet</div>
                <div class="info-value"><?= htmlspecialchars($_SESSION['prenom_employe']) . " " . htmlspecialchars($_SESSION['nom_employe']); ?></div>

                <div class="info-label">Adresse Mail</div>
                <div class="info-value"><?= htmlspecialchars($_SESSION['adresse_email']); ?></div>

                <div class="info-label">Téléphone Personnel</div>
                <div class="info-value"><?= htmlspecialchars($_SESSION['telephone_perso']); ?></div>

                <div class="info-label">Mot de passe</div>
                <div class="info-value">
                    <a href="password_change.php">Changer le mot de passe</a>
                </div>
            </div>
        </div>

        <!-- Section Informations Professionnelles -->
        <div class="profile-section">
            <h2>Informations Professionnelles</h2>
            <div class="info-grid">
                <div class="info-label">Département</div>
                <div class="info-value"><?= htmlspecialchars($_SESSION['departement_employe']); ?></div>

                <div class="info-label">Poste</div>
                <div class="info-value"><?= htmlspecialchars($_SESSION['poste_employe']); ?></div>

                <div class="info-label">Téléphone Professionnel</div>
                <div class="info-value"><?= htmlspecialchars($_SESSION['telephone_pro']); ?></div>

                <div class="info-label">Date d'arrivée</div>
                <div class="info-value"><?= htmlspecialchars($_SESSION['date_d_arrivee']); ?></div>

                <div class="info-label">Contacter l'Administrateur</div>
                <div class="info-value">
                    <?php
                    $mailAdmin = $pdo->prepare('SELECT adresse_email FROM employés WHERE admin = 1');
                    $mailAdmin->execute([]);
                    $value = $mailAdmin->fetch(PDO::FETCH_ASSOC);

                    if ($value) {
                        echo htmlspecialchars($value['adresse_email']);
                    } else {
                        echo "Aucun administrateur trouvé.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "includes/footer.php";
?>