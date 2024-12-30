<?php
include "includes/header.php";

//messages d'erreur et de succès
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputEmail = isset($_POST['email']) ? trim($_POST['email']) : '';

    // on check si l'adresse mail est dans la bd
    if (!empty($inputEmail)) {
        $stmt = $pdo->prepare('SELECT * FROM employes WHERE adresse_email = :email');
        $stmt->execute(['email' => $inputEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // token pour reset
            $resetToken = bin2hex(random_bytes(16));
            $expiryTime = date("Y-m-d H:i:s", strtotime('+1 hour')); // limite de 1h pour changer son mdp, possible d'ajuster pour + de sécurité

            // Enregistrer le token dans la base de données
            $stmt = $pdo->prepare('INSERT INTO password_reset (email, reset_token, expiry_time) VALUES (:email, :token, :expiry_time)');
            $stmt->execute([
                'email' => $inputEmail,
                'token' => $resetToken,
                'expiry_time' => $expiryTime
            ]);

            //lien de réinitialisation par e-mail
            $resetLink = "http://votresite.com/reset_mot_de_passe.php?token=" . $resetToken;

            //envoi du mail à l'utilisateur qui a perdu son mdp
            $subject = "Réinitialisation de votre mot de passe";
            $message = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : " . $resetLink;
            mail($inputEmail, $subject, $message);

            $successMessage = "Un e-mail de réinitialisation a été envoyé à votre adresse.";
        } else {
            $errorMessage = "Aucun utilisateur trouvé avec cet e-mail.";
        }
    } else {
        $errorMessage = "Veuillez entrer votre adresse e-mail.";
    }
}
?>

<div class="mot-de-passe-oublie">
    <h2>Réinitialisation du mot de passe</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" placeholder="Votre e-mail" required>
        </div>
        <button type="submit" class="btn">Envoyer le lien de réinitialisation</button>
    </form>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <?php if ($successMessage): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>
</div>

<?php
include "includes/footer.php";
?>