<?php
include "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Gérico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/footer.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row top-bar">
            <div class="col-4 logo">
                <a href="../index.php"><img src="../images/GERICO-transparent.png" alt="Logo" style="width: 50px;"></a>

            </div>
            <div class="col-4 text-center d-flex align-items-center justify-content-center">

                <?php if (isset($_SESSION['nom_employe']) && isset($_SESSION['prenom_employe'])): ?>
                    <?= htmlspecialchars($_SESSION['prenom_employe']) . " " . htmlspecialchars($_SESSION['nom_employe']); ?>

                <?php else: ?>

                <?php endif; ?>
            </div>
            <div class="col-4 text-end d-flex align-items-center justify-content-end">

                <?php if (isset($_SESSION['login'])): ?>
                    <a href="../deconnexion.php" class="d-block mb-3 btn btn-danger">Déconnexion</a>

                <?php else: ?>
                    <a href="../connexion.php" class="d-block mb-3 btn btn-primary">Connexion</a>

                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 sidebar">
                <a href="index.php" class="d-block mb-3 btn btn-primary">Accueil</a>

                <?php if (isset($_SESSION['id_employe']) && $_SESSION['admin'] == 0): ?>
                    <a href="../bulletins.php" class="d-block mb-3 btn btn-primary">Mes bulletins de paie</a>
                    <a href="../calendrier.php" class="d-block mb-3 btn btn-primary">Mon calendrier</a>
                    <a href="../profil.php" class="d-block mb-3 btn btn-primary">Mon profil</a>

                <?php elseif (isset($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>
                    <a href="../pages_admin/gestion_bulletins.php" class="d-block mb-3 btn btn-primary">Gestion Bulletins de Paie</a>
                    <a href="../pages_admin/gestion_salaries.php" class="d-block mb-3 btn btn-primary">Gestion Salariés</a>
                    <a href="../pages_admin/gestion_calendrier.php" class="d-block mb-3 btn btn-primary">Calendrier de l'Entreprise</a>
                    <a href="../profil.php" class="d-block mb-3 btn btn-primary">Mon profil</a>

                <?php endif; ?>

            </div>

            <div class="col-10">
                <!--Le code n'est pas fini ici, car tout le contenu de notre site se passera dans cette balise div, on "coupe" le code en 2 parties, 
en mettant une moitié de code ici et l'autre moitié dans le footer, comme ça on peut écrire entre les deux sans aucune difficulté avec le "require includes/header.php et footer.php"  -->