<?php
require('vendor/fpdf/fpdf.php');
include_once '../../config.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Rapport des Signalements par Statut',0,1,'C');
        $this->Ln(5);
    }

    function SectionTitle($title, $color) {
        $this->SetFont('Arial','B',12);
        $this->SetFillColor(...$color);
        $this->SetTextColor(255,255,255);
        $this->Cell(0,10,"$title",0,1,'L',true);
        $this->Ln(2);
    }

    function TableHeader() {
        $this->SetFont('Arial','B',10);
        $this->SetFillColor(230,230,230);
        $this->SetTextColor(0);
        $this->Cell(40,8,'Titre',1,0,'C',true);
        $this->Cell(60,8,'Description',1,0,'C',true);
        $this->Cell(60,8,'Emplacement',1,0,'C',true);
        $this->Cell(35,8,'Date',1,1,'C',true);
    }

    function AddSignalements($data) {
        $this->SetFont('Arial','',10);
    
        foreach ($data as $row) {
            $w = [40, 60, 60, 35]; // Largeurs
            $lineHeight = 5;
    
            // Contenu
            $titre = utf8_decode($row['titre']);
            $desc = utf8_decode($row['description']);
            $empl = utf8_decode($row['emplacement']);
            $date = $row['date_signalement'];
    
            // Calcule le nb max de lignes nécessaires
            $nbLines = max(
                $this->NbLines($w[0], $titre),
                $this->NbLines($w[1], $desc),
                $this->NbLines($w[2], $empl),
                $this->NbLines($w[3], $date)
            );
            $rowHeight = $lineHeight * $nbLines;
    
            $x = $this->GetX();
            $y = $this->GetY();
    
            // Cellule titre
            $this->Rect($x, $y, $w[0], $rowHeight);
            $this->MultiCell($w[0], $lineHeight, $titre, 0, 'L');
            $this->SetXY($x + $w[0], $y);
    
            // Cellule description
            $this->Rect($x + $w[0], $y, $w[1], $rowHeight);
            $this->MultiCell($w[1], $lineHeight, $desc, 0, 'L');
            $this->SetXY($x + $w[0] + $w[1], $y);
    
            // Cellule emplacement
            $this->Rect($x + $w[0] + $w[1], $y, $w[2], $rowHeight);
            $this->MultiCell($w[2], $lineHeight, $empl, 0, 'L');
            $this->SetXY($x + $w[0] + $w[1] + $w[2], $y);
    
            // Cellule date
            $this->Rect($x + $w[0] + $w[1] + $w[2], $y, $w[3], $rowHeight);
            $this->MultiCell($w[3], $lineHeight, $date, 0, 'C');
    
            // Aller à la ligne suivante
            $this->SetXY($x, $y + $rowHeight);
        }
    
        $this->Ln(2);
    }
    
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}

// Connexion à la BDD
$db = config::getConnection();

// Couleurs des sections
$statuts = [
    'En attente' => [255, 193, 7],
    'En cours'   => [255, 87, 34],
    'Resolu'     => [76, 175, 80],
];

$pdf = new PDF();
$pdf->AddPage();

foreach ($statuts as $statut => $color) {
    $stmt = $db->prepare("SELECT titre, description, emplacement, date_signalement FROM signalement WHERE statut = :statut");
    $stmt->execute(['statut' => $statut]);
    $signalements = $stmt->fetchAll();

    if (count($signalements) > 0) {
        $pdf->SectionTitle($statut, $color);
        $pdf->TableHeader();
        $pdf->AddSignalements($signalements);
    }
}

$pdf->Output('I', 'signalements_par_statut.pdf');
