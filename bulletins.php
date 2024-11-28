<?php

include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/bulletins.css">
    <title>Mes bulletins de paie</title>
</head>

<body>

    <h1>Mes bulletins de paie</h1>

    <div class="filter-section">
        <label for="mois">Mois :</label>
        <input type="text" id="mois" placeholder="Janvier">
        <label for="annee">Année :</label>
        <input type="text" id="annee" placeholder="2024">
        <button onclick="rechercher()">Rechercher</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Intitulé</th>
                <th>Fichier</th>
                <th>Visualiser</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Janvier 2024</td>
                <td>Bulletin de salaire</td>
                <td><a href="#">Télécharger</a></td>
                <td><a href="#" target="_blank">Visualiser</a></td>
            </tr>
            <tr>
                <td>Janvier 2023</td>
                <td>Bulletin de salaire</td>
                <td><a href="#">Télécharger</a></td>
                <td><a href="#" target="_blank">Visualiser</a></td>
            </tr>
            <tr>
                <td>Janvier 2022</td>
                <td>Bulletin de salaire</td>
                <td><a href="#">Télécharger</a></td>
                <td><a href="#" target="_blank">Visualiser</a></td>
            </tr>
            <tr>
                <td>Janvier 2021</td>
                <td>Bulletin de salaire</td>
                <td><a href="#">Télécharger</a></td>
                <td><a href="#" target="_blank">Visualiser</a></td>
            </tr>
        </tbody>
    </table>

    <script>
        function rechercher() {
            alert("Fonction de recherche à implémenter.");
        }
    </script>

</body>

</html>


</html>
<?php
include 'includes/footer.php';
?>