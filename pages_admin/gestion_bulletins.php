<?php
include "../includes/header.php";

echo '<div class="content">
        <h2>Recherche des fiches de paie</h2>
    
        <form method="POST" action="gestion_bulletins.php" class="search-form">
            <label for="nom_salarie">Nom du salarié</label>
            <input type="text" id="nom_salarie" name="nom_salarie" placeholder="Nom du salarié">
    
            <label for="mois">Mois (1-12)</label>
            <input type="number" id="mois" name="mois" min="1" max="12" placeholder="Mois">
    
            <label for="annee">Année</label>
            <input type="number" id="annee" name="annee" min="2000" max="2100" placeholder="Année">
    
            <button type="submit">Rechercher</button>
        </form>
    </div>
    ';


// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialiser la requête SQL
    $sql = "";
    $params = [];

    // Récupérer les champs du formulaire
    $nom_salarie = $_POST['nom_salarie'] ?? '';
    $mois = $_POST['mois'] ?? '';
    $annee = $_POST['annee'] ?? '';

    if (!empty($nom_salarie) && !empty($mois) && !empty($annee)) {
        // Rechercher par nom, mois et année
        $sql = "SELECT f.id_fiche, f.date_fiche, f.salaire_brut, f.salaire_net, e.nom_employe, e.prenom_employe 
                    FROM fiche_de_paie f
                    JOIN employés e ON f.id_employe = e.id_employe
                    WHERE e.nom_employe LIKE CONCAT('%', :nom_salarie, '%') 
                    AND MONTH(f.date_fiche) = :mois 
                    AND YEAR(f.date_fiche) = :annee";
        $params[':nom_salarie'] = $nom_salarie;
        $params[':mois'] = $mois;
        $params[':annee'] = $annee;
    } elseif (!empty($nom_salarie) && !empty($annee)) {
        // Rechercher par employé et année
        $sql = "SELECT f.id_fiche, f.date_fiche, f.salaire_brut, f.salaire_net, e.nom_employe, e.prenom_employe 
                    FROM fiche_de_paie f
                    JOIN employés e ON f.id_employe = e.id_employe
                    WHERE e.nom_employe LIKE CONCAT('%', :nom_salarie, '%')
                    AND YEAR(f.date_fiche) = :annee";
        $params[':nom_salarie'] = $nom_salarie;
        $params[':annee'] = $annee;
    } elseif (!empty($nom_salarie)) {
        // Rechercher les fiches d'un employé
        $sql = "SELECT f.id_fiche, f.date_fiche, f.salaire_brut, f.salaire_net, e.nom_employe, e.prenom_employe 
                    FROM fiche_de_paie f
                    JOIN employés e ON f.id_employe = e.id_employe
                    WHERE e.nom_employe LIKE CONCAT('%', :nom_salarie, '%')";
        $params[':nom_salarie'] = $nom_salarie;
    } elseif (!empty($mois) && !empty($annee)) {
        // Rechercher par mois et année
        $sql = "SELECT f.id_fiche, f.date_fiche, f.salaire_brut, f.salaire_net, e.nom_employe, e.prenom_employe 
                    FROM fiche_de_paie f
                    JOIN employés e ON f.id_employe = e.id_employe
                    WHERE MONTH(f.date_fiche) = :mois AND YEAR(f.date_fiche) = :annee";
        $params[':mois'] = $mois;
        $params[':annee'] = $annee;
    } elseif (!empty($annee)) {
        // Rechercher par année uniquement
        $sql = "SELECT f.id_fiche, f.date_fiche, f.salaire_brut, f.salaire_net, e.nom_employe, e.prenom_employe 
                    FROM fiche_de_paie f
                    JOIN employés e ON f.id_employe = e.id_employe
                    WHERE YEAR(f.date_fiche) = :annee";
        $params[':annee'] = $annee;
    }


    // Préparer et exécuter la requête
    if (!empty($sql)) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo "<table border='1'>";
            echo "<tr><th>ID Fiche</th><th>Date</th><th>Salaire Brut</th><th>Salaire Net</th><th>Nom Employé</th><th>Prénom Employé</th></tr>";
            foreach ($result as $row) {
                echo "<tr><td>{$row['id_fiche']}</td><td>{$row['date_fiche']}</td><td>{$row['salaire_brut']}</td><td>{$row['salaire_net']}</td><td>{$row['nom_employe']}</td><td>{$row['prenom_employe']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun résultat trouvé.";
        }
    } else {
        echo "Veuillez remplir un des champs pour effectuer une recherche.";
    }
}



include "../includes/footer.php";
