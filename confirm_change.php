<?php
include "includes/header.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_password'];
    $reconfirm_new_password = $_POST['confirm_password'];

    // Exemple de validation
    if (empty($current_password) || empty($new_password) || empty($confirm_new_password) || empty($reconfirm_new_password)) {
        $message = "Tous les champs doivent être remplis.";
        $message_type = "error";
    } elseif ($new_password !== $confirm_new_password && $new_password !== $reconfirm_new_password) {
        $message = "Le nouveau mot de passe et sa confirmation ne correspondent pas.";
        $message_type = "error";
    } else {
        try {
            // Récupérer le mot de passe actuel depuis la base de données
            $stmt = $pdo->prepare('SELECT mot_de_passe FROM employés WHERE id_employe = :id');
            $stmt->execute(['id' => $_SESSION['id_employe']]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            // en cas d'erreur
            if (!empty($res)) {
                //si le mdp hashé correspond au mdp saisi par l'utilisateur
                if (password_verify($current_password, $res['mot_de_passe'])) {
                    // maj du mdp
                    $new_password = password_hash($new_password, PASSWORD_BCRYPT);
                    $stmt = $pdo->prepare('UPDATE employés SET mot_de_passe = :mdp WHERE id_employe = :id');
                    $stmt->execute([
                        'id' => $_SESSION['id_employe'],
                        'mdp' => $new_password,
                    ]);
                    header('Location: profil.php');
                    exit;
                }
            } else {
                $message_type = "error";
                header('Location: password_change.php');
                echo "Erreur";
                exit;
            }
        } catch (PDOException $e) {
            $message = "Une erreur est survenue : " . $e->getMessage();
            $message_type = "error";
            header('Location: password_change.php');
            echo "Erreur";
            exit;
        }
    }
}
