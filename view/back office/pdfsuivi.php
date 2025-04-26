<?php
require('vendor/fpdf/fpdf.php');
include_once '../../Controller/SuiviC.php';
include_once '../../Controller/signalementctrl.php';
include_once '../../config.php';

if (!isset($_GET['id_signalement'])) {
    die('ID Signalement non fourni');
}

$id_signalement = $_GET['id_signalement'];

$suivic = new SuiviC();
$signalementC = new SignalementC();

$signalement = $signalementC->recupererSignalement($id_signalement);
$suivis = $suivic->getSuivisBySignalement($id_signalement);

if (!$signalement) {
    die('Signalement non trouvé');
}

$pdf = new FPDF();
$pdf->AddPage();

// Header
$pdf->SetFont('Arial', 'B', 18);
$pdf->SetTextColor(0, 102, 204); // Bleu
$pdf->Cell(0, 15, utf8_decode('Rapport Signalement et Suivis'), 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0); // Retour au noir
$pdf->SetFont('Arial', '', 12);

// Signalement Infos
$pdf->SetFillColor(230, 230, 230); // Gris clair
$pdf->Cell(50, 10, 'ID Signalement:', 1, 0, 'L', true);
$pdf->Cell(0, 10, $signalement['id_signalement'], 1, 1);

$pdf->Cell(50, 10, 'Titre:', 1, 0, 'L', true);
$pdf->Cell(0, 10, utf8_decode($signalement['titre']), 1, 1);

$pdf->Cell(50, 10, 'Date:', 1, 0, 'L', true);
$pdf->Cell(0, 10, $signalement['date_signalement'], 1, 1);

$pdf->Cell(50, 10, 'Emplacement:', 1, 0, 'L', true);
$pdf->Cell(0, 10, utf8_decode($signalement['emplacement']), 1, 1);

$pdf->Cell(50, 10, 'Statut:', 1, 0, 'L', true);
$pdf->Cell(0, 10, utf8_decode($signalement['statut']), 1, 1);

$pdf->Cell(50, 10, 'Description:', 1, 0, 'L', true);
$pdf->Cell(0, 10, utf8_decode($signalement['description']), 1, 1);


$pdf->Ln(10);

// Liste des Suivis
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 102, 204);
$pdf->Cell(0, 10, utf8_decode('Liste des Suivis :'), 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 11);

if (count($suivis) > 0) {
    foreach($suivis as $suivi) {
        $pdf->SetFillColor(240, 248, 255); // Couleur très légère pour chaque suivi
        $pdf->Cell(50, 10, 'Date Suivi:', 1, 0, 'L', true);
        $pdf->Cell(0, 10, $suivi['date_suivi'], 1, 1);

        $pdf->Cell(50, 10, 'Service Responsable:', 1, 0, 'L', true);
        $pdf->Cell(0, 10, utf8_decode($suivi['service_responsable']), 1, 1);

        $pdf->Cell(50, 10, 'Statut:', 1, 0, 'L', true);
        $pdf->Cell(0, 10, utf8_decode($suivi['statut']), 1, 1);

        $pdf->Cell(50, 10, 'Description:', 1, 0, 'L', true);
        $pdf->MultiCell(0, 10, utf8_decode($suivi['description']), 1);

        $pdf->Cell(50, 10, 'Description:', 1, 0, 'L', true);
        $pdf->Cell(0, 10, utf8_decode($signalement['description']), 1, 1);
        
        $pdf->Ln(5); // Espace entre les suivis
    }
} else {
    $pdf->Cell(0, 10, 'Aucun suivi pour ce signalement.', 1, 1, 'C');
}

// Footer
$pdf->SetY(-20);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Généré le '.date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(0, 10, 'Page '.$pdf->PageNo().'/{nb}', 0, 0, 'R');

$pdf->Output();
?>
