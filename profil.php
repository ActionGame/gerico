<?php
include "includes/header.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="styles/profil.css">

</head>

<body>
    <div class="profile-container">
        <div class="profile-header">
            <!-- Affiche nom_employe et prenom_employe stockés dans la bd -->
            <h1><?= htmlspecialchars($_SESSION['prenom_employe']) . " " . htmlspecialchars($_SESSION['nom_employe']); ?></h1>
            <p><?= htmlspecialchars($_SESSION['login']); ?></p>
        </div>
        <div class="profile-content">
            <div class="profile-section">
                <!-- Affiche les infos stockées dans la BD de façon plus esthétique-->
                <h2>Informations Personnelles</h2>
                <table>
                    <tr>
                        <td>Nom Complet</td>
                        <td>
                            <?= htmlspecialchars($_SESSION['prenom_employe']) . " " . htmlspecialchars($_SESSION['nom_employe']); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Adresse Mail</td>
                        <td><?= htmlspecialchars($_SESSION['adresse_email']); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Téléphone Personnel: </td>
                        <td><?= htmlspecialchars($_SESSION['telephone_perso']); ?></td>
                    </tr>
                    <tr>
                        <td>Mot de passe</td>
                        <td>Changer le mot de passe</td>
                        <td></td>
                    </tr>
                </table>
            </div>

            <div class="profile-section">
                <h2>Informations Professionelles</h2>
                <table>
                    <tr>
                        <td>Département</td>
                        <td><?= htmlspecialchars($_SESSION['departement_employe']); ?></td>
                    </tr>
                    <tr>
                        <td>Poste</td>
                        <td><?= htmlspecialchars($_SESSION['poste_employe']); ?></td>
                    </tr>
                    <tr>
                        <td>Téléphone Professionel: </td>
                        <td><?= htmlspecialchars($_SESSION['telephone_pro']); ?></td>
                    </tr>
                    <tr>
                        <td>Date d'arrivée</td>
                        <td>
                            <?= htmlspecialchars($_SESSION['date_d_arrivee']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Contacter l'Administrateur</td>
                        <td>
                            <!-- Affiche le mail admin pour le contacter en cas de bug sur le site. -->
                            <?php
                            $mailAdmin = $pdo->prepare('SELECT adresse_email FROM employés WHERE admin = 1 AND id_employe = 1');
                            $mailAdmin->execute([]);
                            $value = $mailAdmin->fetch(PDO::FETCH_ASSOC); // Récupération d'un enregistrement

                            if ($value) {
                                echo htmlspecialchars($value['adresse_email']); // Affichage sécurisé de l'adresse e-mail
                            } else {
                                echo "Aucun administrateur trouvé.";
                            }
                            ?>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>


<?php
include "includes/footer.php";
?>