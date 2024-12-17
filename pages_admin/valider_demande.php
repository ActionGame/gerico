<?php
include '../includes/pdo.php';

//ce fichier exécute la requête mettant à jour l'état de la demande de congé dans la BD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_conge = $_POST['id_conge'];

    // requête sql
    $stmt = $pdo->prepare('UPDATE demande_de_congés SET etat_demande = "validé" WHERE id_conge = :id');
    $stmt->bindParam(':id', $id_conge, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Demande validée avec succès.";
    } else {
        echo "Erreur lors de la validation de la demande.";
    }

    // on retourne sur la page du calendrier une fois la commande exécutée.
    header('Location: ../pages_admin/gestion_calendrier.php');
    exit;
}
