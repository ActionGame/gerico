<?php
include 'includes/header.php';
include "includes/pdo.php";

// Lire les données JSON reçues
$data = json_decode(file_get_contents('php://input'), true);
$startDate = $data['startDate'] ?? null;
$endDate = $data['endDate'] ?? null;
$motif = $data['message'] ?? '';

if ($startDate && $endDate) {
    // Insérer les données dans la base de données
    $stmt = $pdo->prepare('INSERT INTO demande_de_congés (date_debut, date_fin, type_conge, etat_demande, date_demande, motif_demande, conge_dispo, id_jour, id_employe) VALUES (:startDate, :endDate, "feur", "En cours", :date_jour , :motif, 0, :jour, :id_employe)');
    $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate, 'date_jour' => date('Y-m-d'), 'jour' => 3, 'id_employe' => $_SESSION['id_employe'], 'motif' => $motif]);
} else {
    http_response_code(400);
}
