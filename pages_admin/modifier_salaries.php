<?php
// Inclusion du fichier d'en-tête contenant les configurations ou éléments partagés
include "header.php";
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

// Récupérer l'identifiant de l'employé à partir des paramètres GET (URL)
$id_employe = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Vérifier si le formulaire a été soumis (requête POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et sécuriser les données saisies dans le formulaire
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $telephone_pro = $conn->real_escape_string($_POST['telephone_pro']);
    $telephone_perso = $conn->real_escape_string($_POST['telephone_perso']);
    $login = $conn->real_escape_string($_POST['login']);
    $date_d_arrivee = $conn->real_escape_string($_POST['date_d_arrivee']);
    $poste_employe = $conn->real_escape_string($_POST['poste_employe']);
    $departement_employe = $conn->real_escape_string($_POST['departement_employe']);
    $adresse_email = $conn->real_escape_string($_POST['adresse_email']);
    $adresse_physique = $conn->real_escape_string($_POST['adresse_physique']);
    $admin = isset($_POST['admin']) ? 1 : 0;

    // Requête SQL pour mettre à jour les informations de l'employé
    $sql = "UPDATE employés 
            SET nom_employe='$nom', prenom_employe='$prenom', telephone_pro='$telephone_pro', telephone_perso='$telephone_perso', 
                login='$login', date_d_arrivee='$date_d_arrivee', poste_employe='$poste_employe', 
                departement_employe='$departement_employe', adresse_email='$adresse_email', adresse_physique='$adresse_physique', 
                admin=$admin 
            WHERE id_employe=$id_employe";

    // Exécuter la requête et vérifier si elle a réussi
    if ($conn->query($sql) === TRUE) {
        header("Location: administration_salaries.php");
        exit();
    } else {
        $message = "Erreur lors de la mise à jour : " . $conn->error;
    }
}

// Récupérer les données actuelles de l'employé pour les afficher dans le formulaire
$sql = "SELECT * FROM employés WHERE id_employe=$id_employe";
$result = $conn->query($sql);

// Vérifier si un employé correspondant a été trouvé
if ($result->num_rows > 0) {
    $employe = $result->fetch_assoc();
} else {
    die("Aucun employé trouvé avec l'ID spécifié.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/modifier_salaries.css">
    <title>Modifier un salarié</title>
</head>
<body>
    <h1 style="text-align: center;">Modifier un salarié</h1>

    <!-- Formulaire pour modifier un salarié -->
    <form action="" method="post">
        <!-- Champ pour le nom -->
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($employe['nom_employe']); ?>" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($employe['prenom_employe']); ?>" required>

        <label for="telephone_pro">Téléphone professionnel :</label>
        <input type="text" id="telephone_pro" name="telephone_pro" value="<?php echo htmlspecialchars($employe['telephone_pro']); ?>" required>

        <label for="telephone_perso">Téléphone personnel :</label>
        <input type="text" id="telephone_perso" name="telephone_perso" value="<?php echo htmlspecialchars($employe['telephone_perso']); ?>">

        <label for="login">Login :</label>
        <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($employe['login']); ?>">

        <label for="date_d_arrivee">Date d'arrivée :</label>
        <input type="date" id="date_d_arrivee" name="date_d_arrivee" value="<?php echo htmlspecialchars($employe['date_d_arrivee']); ?>" required>

        <label for="poste_employe">Poste :</label>
        <input type="text" id="poste_employe" name="poste_employe" value="<?php echo htmlspecialchars($employe['poste_employe']); ?>" required>

        <label for="departement_employe">Département :</label>
        <input type="text" id="departement_employe" name="departement_employe" value="<?php echo htmlspecialchars($employe['departement_employe']); ?>" required>

        <label for="adresse_email">Adresse email :</label>
        <input type="email" id="adresse_email" name="adresse_email" value="<?php echo htmlspecialchars($employe['adresse_email']); ?>" required>

        <label for="adresse_physique">Adresse physique :</label>
        <input type="text" id="adresse_physique" name="adresse_physique" value="<?php echo htmlspecialchars($employe['adresse_physique']); ?>" required>

        <label for="admin">Administrateur :</label>
        <input type="checkbox" id="admin" name="admin" <?php echo $employe['admin'] ? 'checked' : ''; ?>>

        <input type="submit" value="Modifier le salarié">
    </form>

    <!-- Lien pour retourner à la liste des salariés -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="../pages_admin/gestion_salaries.php" class="btn-back" style="text-decoration: none; padding: 10px 20px; border: none; background-color: #007BFF; color: white; border-radius: 4px;">Retour à la liste des salariés</a>
    </div>

    <!-- Afficher un message de confirmation ou d'erreur -->
    <?php if (isset($message)): ?>
        <div class="message">
            <p><?php echo htmlspecialchars($message); ?></p>
        </div>
    <?php endif; ?>
</body>
</html>
