
<?php 
include "fpdf/fpdf.php";
include "function/pdf_requete.php";

// Instanciation de l'objet FDPF
$pdf = new FPDF();

// Création d'une page
$pdf->AddPage();

// Définit l'alias du nombre de pages {nb}
$pdf->AliasNbPages();

$pdf->SetMargins(10,10,20); // Nouvelles marges en mm
$pdf->SetDrawColor(0,0,0); // Tracé Noir
// Marge du bas et saut automatique
$pdf->SetAutoPageBreak(true,10);
$pdf->Ln(80);
// Création du titre
$pdf->SetFont('Times', 'B', 18);
$pdf->Cell(110,10,utf8_decode('Cumul des frais'),0,0,'R');  // utf8_decode=convertit en ASCII une chaine UTF8

$pdf->Ln(15); // saut de ligne

// Entête
$pdf->SetFont('Times', '', 9);
$pdf->SetFont('', 'B');
$pdf->SetX(8);
$pdf->SetFillColor(177,254,152);
$pdf->Cell(55, 8, utf8_decode("Ligue"), 1,0,"C");
$pdf->Cell(20, 8, utf8_decode("Club"), 1,0,"C");
$pdf->Cell(40, 8, utf8_decode("Motif"), 1,0,"C");
$pdf->Cell(30, 8, utf8_decode("Période"), 1,0,"C");
$pdf->Cell(35, 8, utf8_decode("Montant de la période"), 1,1,"C");
// Contenu

foreach ($cumuls as $cumul) {
    $pdf->SetFont('', '');
    $pdf->SetX(8);
    $pdf->SetFillColor(177,254,152);
    $pdf->Cell(55,8, utf8_decode($cumul["NomLigue"]),1,0,"C",true);   
    $pdf->Cell(20,8, utf8_decode($cumul["NomClub"]),1,0,"C",true);
    $pdf->Cell(40,8, utf8_decode($cumul["NomMotif"]),1,0,"C",true);
    $pdf->Cell(30,8, utf8_decode($cumul["Periode"]),1,0,"C",true);
    $pdf->SetFillColor(133,241,238);
    $pdf->Cell(35,8, utf8_decode($cumul["MtPeriode"]),1,1,"C",true);
 }


// Génération du document PDF dans le dossier outfiles
$pdf->Output('outfiles/cumul.pdf','f');  // f=fichier local
//header('Location: notes_frais.php');
?>

    </body>
</html>