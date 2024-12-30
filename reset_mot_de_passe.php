<?php
include "includes/header.php";
$errorMessage = "";
$successMessage = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // le token existe et est valide ?
    $stmt = $pdo->prepare('SELECT * FROM password_reset WHERE reset_token = :token');
    $stmt->execute(['token' => $token]);
    $resetRequest = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resetRequest) {
        // si le token n'a pas expiré
        if (strtotime($resetRequest['expiry_time']) > time()) {
            // page de réinitialisation
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
                $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

                if (!empty($newPassword) && $newPassword === $confirmPassword) {
                    // hashage du nouveau mdp et ajout dans la bd
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare('UPDATE employés SET mot_de_passe = :password WHERE adresse_email = :email');
                    $stmt->execute(['password' => $hashedPassword, 'email' => $resetRequest['email']]);

                    // on supprime le token dans la bd car il est inutile maintenant
                    $stmt = $pdo->prepare('DELETE FROM password_reset WHERE reset_token = :token');
                    $stmt->execute(['token' => $token]);

                    $successMessage = "Votre mot de passe a été réinitialisé avec succès.";
                } else {
                    $errorMessage = "Les mots de passe ne correspondent pas.";
                }
            }
        } else {
            $errorMessage = "Le lien de réinitialisation a expiré.";
        }
    } else {
        $errorMessage = "Lien invalide.";
    }
}
?>

<div class="reset-mot-de-passe">
    <h2>Réinitialiser le mot de passe</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="new_password">Nouveau mot de passe :</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn">Réinitialiser le mot de passe</button>
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