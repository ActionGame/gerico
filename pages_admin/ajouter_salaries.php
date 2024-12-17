<?php
// Inclusion du fichier d'en-tête contenant les configurations ou éléments partagés
include "header.php";

// Vérifier si le formulaire a été soumis (via une requête POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Connexion à la base de données ---
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gerico";

    // Création de la connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Récupérer et sécuriser les données saisies dans le formulaire
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $telephone_pro = $conn->real_escape_string($_POST['telephone_pro']);
    $telephone_perso = $conn->real_escape_string($_POST['telephone_perso']);
    $login = $conn->real_escape_string($_POST['login']);
    $mot_de_passe = password_hash($conn->real_escape_string($_POST['mot_de_passe']), PASSWORD_BCRYPT);
    $date_d_arrivee = $conn->real_escape_string($_POST['date_d_arrivee']);
    $poste_employe = $conn->real_escape_string($_POST['poste_employe']);
    $departement_employe = $conn->real_escape_string($_POST['departement_employe']);
    $adresse_email = $conn->real_escape_string($_POST['adresse_email']);
    $adresse_physique = $conn->real_escape_string($_POST['adresse_physique']);
    $admin = isset($_POST['admin']) ? 1 : 0;

    // Vérifier que tous les champs obligatoires ont été remplis
    if (
        !empty($nom) && !empty($prenom) && !empty($telephone_pro) && !empty($mot_de_passe) &&
        !empty($date_d_arrivee) && !empty($poste_employe) && !empty($departement_employe) && !empty($adresse_email) && !empty($adresse_physique)
    ) {

        // Construire la requête SQL pour insérer les données dans la base
        $sql = "INSERT INTO employés (nom_employe, prenom_employe, telephone_pro, telephone_perso, login, mot_de_passe, date_d_arrivee, poste_employe, departement_employe, adresse_email, adresse_physique, admin)
                VALUES ('$nom', '$prenom', '$telephone_pro', '$telephone_perso', '$login', '$mot_de_passe', '$date_d_arrivee', '$poste_employe', '$departement_employe', '$adresse_email', '$adresse_physique', $admin)";

        // Exécuter la requête et vérifier si elle a réussi
        if ($conn->query($sql) === TRUE) {
            $message = "Le salarié a été ajouté avec succès.";
        } else {
            $message = "Erreur : " . $conn->error;
        }
    } else {
        $message = "Veuillez remplir tous les champs obligatoires.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>

<head>
    <link rel="stylesheet" href="../styles/gestion_calendrier.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Ajouter un nouveau salarié</h1>

        <!-- Formulaire pour ajouter un salarié -->
        <form class="form" action="ajouter_salaries.php" method="post">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>
            </div>

            <div class="form-group">
                <label for="telephone_pro">Téléphone professionnel :</label>
                <input type="text" id="telephone_pro" name="telephone_pro" placeholder="Téléphone professionnel" required>
            </div>

            <div class="form-group">
                <label for="telephone_perso">Téléphone personnel :</label>
                <input type="text" id="telephone_perso" name="telephone_perso" placeholder="Téléphone personnel">
            </div>

            <div class="form-group">
                <label for="login">Login :</label>
                <input type="text" id="login" name="login" placeholder="Login">
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required>
            </div>

            <div class="form-group">
                <label for="date_d_arrivee">Date d'arrivée :</label>
                <input type="date" id="date_d_arrivee" name="date_d_arrivee" required>
            </div>

            <div class="form-group">
                <label for="poste_employe">Poste :</label>
                <input type="text" id="poste_employe" name="poste_employe" placeholder="Poste" required>
            </div>

            <div class="form-group">
                <label for="departement_employe">Département :</label>
                <input type="text" id="departement_employe" name="departement_employe" placeholder="Département" required>
            </div>

            <div class="form-group">
                <label for="adresse_email">Adresse email :</label>
                <input type="email" id="adresse_email" name="adresse_email" placeholder="Adresse email" required>
            </div>

            <div class="form-group">
                <label for="adresse_physique">Adresse physique :</label>
                <input type="text" id="adresse_physique" name="adresse_physique" placeholder="Adresse physique" required>
            </div>

            <div class="form-group">
                <label for="admin">Administrateur :</label>
                <input type="checkbox" id="admin" name="admin">
            </div>

            <div class="form-actions">
                <input class="btn btn-primary" type="submit" value="Ajouter le salarié">
            </div>
        </form>

        <!-- Lien pour retourner à la liste des salariés -->
        <div class="link-container">
            <a href="../pages_admin/gestion_salaries.php" class="btn btn-back">Retour à la liste des salariés</a>
        </div>

        <!-- Afficher un message de confirmation ou d'erreur -->
        <?php if (isset($message)): ?>
            <div class="message success">
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>