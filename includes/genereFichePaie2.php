<?php
require 'fpdf/fpdf.php';


// Récupérer les données d'un employé
function getEmployeeData($employeeId, $idFiche)
{
    require 'pdo.php';
    $stmt = $pdo->prepare("select * from employés,fiche_de_paie WHERE employés.id_employe = fiche_de_paie.id_employe and fiche_de_paie.id_employe = :id and id_fiche= :id_fiche");
    $stmt->bindParam(':id', $employeeId, PDO::PARAM_STR);
    $stmt->bindParam(':id_fiche', $idFiche, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Génération de la fiche de paie
function generatePayslip($employeeData)
{
    $pdf = new FPDF();
    $pdf->AddPage();

    // Configuration de la police
    $pdf->SetFont('Arial', 'B', 16);

    // Image
    $pdf->Image('../images/GERICO-transparent.png', 10, 10, -300);

    // Titre
    $pdf->Cell(0, 10, 'Fiche de Paie GERICO', 0, 1, 'C');
    $pdf->Ln(20);

    // Informations sur l'employé
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Nom :', 0, 0);
    $pdf->Cell(50, 10, $employeeData['nom_employe'], 0, 1);

    $pdf->Cell(50, 10, 'Prenom :', 0, 0);
    $pdf->Cell(50, 10, $employeeData['prenom_employe'], 0, 1);

    $pdf->Cell(50, 10, 'Poste :', 0, 0);
    $pdf->Cell(50, 10, $employeeData['poste_employe'], 0, 1);

    $pdf->Cell(50, 10, 'Date de Paie :', 0, 0);
    $pdf->Cell(50, 10, $employeeData['date_fiche'], 0, 1);

    $pdf->Cell(50, 10, 'ID Employé:', 0, 0);
    $pdf->Cell(50, 10, $employeeData['id_employe'], 0, 1);

    $pdf->Ln(10);

    // Premier tableau pour "Nombres d'heures" et "Taux horaire"
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(95, 10, 'Nombres d\'heures :', 1, 0, 'C');
    $pdf->Cell(95, 10, 'Taux horaire :', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(95, 10, number_format($employeeData['nb_heures'], 2), 1, 0, 'C');
    $pdf->Cell(95, 10, number_format($employeeData['taux_horaire'], 2), 1, 1, 'C');

    $pdf->Ln(10);

    // Deuxième tableau pour "Salaire Brut", "Charges", et "Salaire Net"
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(63, 10, 'Salaire Brut :', 1, 0, 'C');
    $pdf->Cell(63, 10, 'Charges :', 1, 0, 'C');
    $pdf->Cell(63, 10, 'Salaire Net :', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(63, 10, number_format($employeeData['salaire_brut'], 2) . ' Euros', 1, 0, 'C');
    $pdf->Cell(63, 10, number_format($employeeData['salaire_brut'] - $employeeData['salaire_net'], 2) . ' Euros', 1, 0, 'C');
    $pdf->Cell(63, 10, number_format($employeeData['salaire_net'], 2) . ' Euros', 1, 1, 'C');

    $pdf->Ln(10);

    // Footer
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Fiche de paie generee automatiquement.', 0, 1, 'C');

    // Sauvegarder ou afficher
    $fileName = 'payslip_' . $employeeData['id_employe'] . '.pdf';
    $pdf->Output($fileName, 'I'); // 'I' pour afficher dans le navigateur 
}


// Exemple d'utilisation
if (isset($_GET['id'])) {
    $employeeId = (int)$_GET['id'];
    $id_fiche = (int)$_GET['fiche'];
    $employeeData = getEmployeeData($employeeId, $id_fiche);

    if ($employeeData) {
        generatePayslip($employeeData);
    } else {
        echo "Aucun employe trouve pour cet ID.";
    }
} else {
    echo "Veuillez fournir un ID d'employe en parametre.";
}
