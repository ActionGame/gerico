<?php
include "includes/header.php";
?>
<div class="password-change-container">
    <h1 class="title">Changer votre mot de passe</h1>

    <!-- Formulaire pour changer le mot de passe -->
    <form class="password-change-form" action="confirm_change.php" method="post">
        <div class="password-change-form-group">
            <label class="password-change-label" for="current_password">Mot de passe actuel :</label>
            <input type="password" id="current_password" name="current_password" placeholder="Entrez votre mot de passe actuel" required>
        </div>

        <div class="password-change-form-group">
            <label class="password-change-label" for="new_password">Nouveau mot de passe :</label>
            <input type="password" id="new_password" name="new_password" placeholder="Entrez un nouveau mot de passe" required>
        </div>

        <div class="password-change-form-group">
            <label class="password-change-label" for="confirm_password">Confirmer le nouveau mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmez le nouveau mot de passe" required>
        </div>

        <div class="password-change-form-group">
            <label class="password-change-label" for="reconfirm_password">Confirmer de nouveau le nouveau mot de passe :</label>
            <input type="password" id="reconfirm_password" name="reconfirm_password" placeholder="Reconfirmez le nouveau mot de passe" required>
        </div>

        <div class="password-change-form-actions">
            <input class="btn btn-primary" type="submit" value="Mettre à jour le mot de passe">
        </div>
    </form>

    <!-- Lien pour retourner au tableau de bord -->
    <div class="link-container">
        <a href="profil.php" class="btn btn-back">Retour au tableau de bord</a>
    </div>
</div>

<?php
include "includes/footer.php";
?>