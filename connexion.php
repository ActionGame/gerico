<?php
include "includes/header.php";
?>

<?php
// msg d'erreur et de succès initialisé ici
$errorMessage = "";
$successMessage = "";

// on stocke le contenu de la saisie utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputLogin = isset($_POST['login']) ? trim($_POST['login']) : '';
    $inputPassword = isset($_POST['mot_de_passe']) ? trim($_POST['mot_de_passe']) : '';
    //ici, appeler la fonction de cryptage en mode "$inputPassword = hashage($inputPassword); avec hashage() la fonction qui renvoie le mot de passe hashé"
    //$inputPassword = password_hash($inputPassword, PASSWORD_DEFAULT);
    // on vérifie si les deux saisies utilisateurs ne sont pas vides
    if (!empty($inputLogin) && !empty($inputPassword)) {
        // preparation de la commande sql et exécution
        $stmt = $pdo->prepare('SELECT * FROM employés WHERE login = :login');
        $stmt->execute([
            'login' => $inputLogin,
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($user)) {
            if (password_verify($inputPassword, $user['mot_de_passe'])) {
                // si connexion réussie
                session_regenerate_id(true);

                //stockage du contenu de l'enregistrement
                $_SESSION['id_employe'] = $user['id_employe'];
                $_SESSION['login'] = $user['login'];
                $_SESSION['nom_employe'] = $user['nom_employe'];
                $_SESSION['prenom_employe'] = $user['prenom_employe'];
                $_SESSION['telephone_pro'] = $user['telephone_pro'];
                $_SESSION['telephone_perso'] = $user['telephone_perso'];
                $_SESSION['date_d_arrivee'] = $user['date_d_arrivee'];
                $_SESSION['poste_employe'] = $user['poste_employe'];
                $_SESSION['departement_employe'] = $user['departement_employe'];
                $_SESSION['adresse_email'] = $user['adresse_email'];
                $_SESSION['adresse_physique'] = $user['adresse_physique'];
                $_SESSION['admin'] = $user['admin'];
                /*
                //stockage des données que l'on ajoute automatiquement à la table connexion à chaque connexion.
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                $date_connexion = date("Y-m-d H:i:s");
                $stmt = $pdo->prepare('INSERT INTO connexion (historique,adresse_ip,id_employe) VALUES (:historique, :ip,:id_emp');
                $stmt->execute(['historique' => $date_connexion, 'ip' => $ip, 'id_emp' => $user['id_employe']]);
                */
                //redirection par défaut au profil utilisateur quand la connexion est faite.
                header('Location: profil.php');
            } else {
                // Connexion échouée
                $errorMessage = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }
    } else {
        $errorMessage = "Veuillez remplir tous les champs.";
    }
}

?>

<div class="connexion col-10">
    <div class="login-container">
        <h2>Connexion</h2>
        <form class="connexion-form" method="POST" action="">
            <div class="connexion-form-group">
                <input type="text" id="login" name="login" placeholder="Login" required>
            </div>
            <div class="connexion-form-group">
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>

        <p><a href="mot_de_passe_oublie.php">Mot de passe oublié ?</a></p>


        <?php if ($errorMessage): ?>
            <div class="alert alert-danger mt-3"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <?php if ($successMessage): ?>
            <div class="alert alert-success mt-3"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>
    </div>
</div>
</div>
</div>

<?php
include "includes/footer.php";
?>
