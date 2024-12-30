<?php
include "../includes/pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_conge = $_POST['id_conge'];

    // Mettre à jour le statut en "refusé"
    $stmt = $pdo->prepare('UPDATE demande_de_congés SET etat_demande = "refusé" WHERE id_conge = ?');
    $stmt->execute([$id_conge]);

    // Redirection après refus
    header("Location: ../pages_admin/gestion_calendrier.php");
    exit();
}
