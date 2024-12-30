<?php
include "pdo.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérico - Transports</title>
    <link rel="stylesheet" href="../styles/all_styles.css">
<<<<<<< HEAD
=======
    <link rel="stylesheet" href="../styles/modifier_salaries.css">
>>>>>>> 14aef7493f10b88f0d1e8d5620a371a38caa163c

</head>

<body>
    <nav class="header-navbar">
        <div class="col-4 logo">
            <a href="../index.php"><img src="../images/GERICO-transparent.png" alt="Logo"></a>
        </div>
        <div class="header-menu-toggle" id="header-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="header-ul" id="header-navbar">
            <li><a href="../index.php" class="d-block mb-3 btn">Accueil</a></li>
            <?php if (isset($_SESSION['id_employe']) && $_SESSION['admin'] == 0): ?>
                <li><a href="../bulletins.php" class="d-block mb-3 btn">Mes bulletins de paie</a></li>
                <li><a href="../calendrier.php" class="d-block mb-3 btn">Mon calendrier</a></li>
                <li><a href="../profil.php" class="d-block mb-3 btn">Mon profil</a></li>

            <?php elseif (isset($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>
                <li><a href="../pages_admin/gestion_bulletins.php" class="d-block mb-3 btn">Gestion Bulletins de Paie</a></li>
                <li><a href="../pages_admin/gestion_salaries.php" class="d-block mb-3 btn">Gestion Salariés</a></li>
                <li><a href="../pages_admin/gestion_calendrier.php" class="d-block mb-3 btn">Calendrier de l'Entreprise</a></li>
                <li><a href="../profil.php" class="d-block mb-3 btn">Mon profil</a></li>
            <?php endif; ?>
            <li>
                <div class="col-4 text-end d-flex align-items-center justify-content-end">

                    <?php if (isset($_SESSION['login'])): ?>
                        <a href="../deconnexion.php" class="d-block mb-3 btn bg-danger">Déconnexion</a>

                    <?php else: ?>
                        <a href="../connexion.php" class="d-block mb-3 btn">Connexion</a>

                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </nav>



    <script>
        const menuToggle = document.getElementById('header-menu-toggle');
        const navbar = document.getElementById('header-navbar');

        menuToggle.addEventListener('click', () => {
            navbar.classList.toggle('active');
        });
    </script>
    <div class="header-col-10">




        <!--Le code n'est pas fini ici, car tout le contenu de notre site se passera dans cette balise div, on "coupe" le code en 2 parties, 
en mettant une moitié de code ici et l'autre moitié dans le footer, comme ça on peut écrire entre les deux sans aucune difficulté avec le "require includes/header.php et footer.php"  -->