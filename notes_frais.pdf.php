
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

// Affichage d'une image
$pdf->Image('img/test.png',10,6,0,10);
$pdf->Ln(8); // revient à la ligne
$pdf->SetDrawColor(0,0,0);

// Création du titre
$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(80,10,utf8_decode('Notes de frais des bénévoles'),0,0,'L');  // utf8_decode=convertit en ASCII une chaine UTF8

//Création de la période
$pdf->SetFillColor(177,254,152);
$pdf->Cell(0,10,utf8_decode('Année Civile '.$periode["lib_periode"]),0,0,'R', true);

$pdf->Ln(10); // saut de ligne
$pdf->SetFont('Times', 'B', 11);
// Création du nom et prénom du user
$pdf->Cell(80,10,utf8_decode('Je soussigné(e)'),0,0,'L');
$pdf->Ln(8);
$pdf->SetFont('Times', '', 11);
$pdf->SetFillColor(177,254,152);
$pdf->Cell(0,10,utf8_decode($utilisateur["nom"]." ".$utilisateur["prenom"]),0,0,'C',true);

//Création de l'adresse
$pdf->Ln(10); // saut de ligne
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(80,10,utf8_decode('demeurant'),0,0,'L');
$pdf->Ln(8);
$pdf->SetFont('Times', '', 11);
$pdf->SetFillColor(177,254,152);
$pdf->Cell(0,10,utf8_decode($adherent["adr1"]." - ".$adherent["adr3"]." - ".$adherent["adr2"]),0,0,'C',true);
$pdf->Ln(10); // saut de ligne

$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(80,10,utf8_decode('certifie renoncer au remboursement des frais ci-dessous et les laisser à l association'),0,0,'L');
$pdf->Ln(8); // saut de ligne

//Adresse club
$pdf->SetFont('Times', '', 11);
$pdf->SetFillColor(177,254,152);
$pdf->Cell(0,10,utf8_decode($club["lib_club"]),0,0,'C',true);
$pdf->Ln(7); // saut de ligne
$pdf->Cell(0,10,utf8_decode($club["adr1"]." - ".$club["adr2"]." - ".$club["adr3"]),0,0,'C',true);
$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(80,10,utf8_decode('En tant que dons.'),0,0,'L');
$pdf->Ln(10); // saut de ligne
// Boucle des lignes
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(80,10,utf8_decode('Frais de déplacement'),0,0,'L');

$pdf->SetFont('Times', '', 11);
$pdf->Cell(80,10,utf8_decode('Tarif kilométrique appliqué pour le remboursement : 0.28 '),0,0,'C');
$pdf->SetTextColor(0, 0, 0); // Noir
$pdf->Ln(8); // saut de ligne

// Entête
$pdf->SetFont('Times', '', 6);
$pdf->SetFont('', 'B');
$pdf->SetX(8);
$pdf->SetFillColor(211,211,211);
$pdf->Cell(16, 8, utf8_decode("Date"), 1,0,"C");
$pdf->Cell(20, 8, utf8_decode("Motif"), 1,0,"C");
$pdf->Cell(23, 8, utf8_decode("Trajet"), 1,0,"C");
$pdf->Cell(20, 8, utf8_decode("Kms parcourus"), 1,0,"C");
$pdf->Cell(30, 8, utf8_decode("Total frais Kms"), 1,0,"C");
$pdf->Cell(20, 8, utf8_decode("Coût péages"), 1,0,"C");
$pdf->Cell(20, 8, utf8_decode("Coût repas"), 1,0,"C");
$pdf->Cell(34, 8, utf8_decode("Coût hébergement"), 1,0,"C");
$pdf->Cell(16, 8, utf8_decode("Total"), 1,1,"C");
// Contenu
$final=0;
foreach ($lignes as $ligne) {

    $final += $ligne["mt_total"];
    $totfrai = $ligne["mt_km"]*$ligne["nb_km"];
    
    $pdf->SetFont('', '');
    $pdf->SetX(8);
    $pdf->SetFillColor(177,254,152);
    $pdf->Cell(16,8, utf8_decode($ligne["dat_ligne"]),1,0,"C",true);
    $pdf->Cell(20,8, utf8_decode($ligne["lib_motif"]),1,0,"C",true); 
    $pdf->Cell(23,8, utf8_decode($ligne["lib_trajet"]),1,0,"C",true);
    $pdf->Cell(20,8, utf8_decode($ligne["nb_km"]),1,0,"C",true);
    $pdf->SetFillColor(133,241,238); 
    $pdf->Cell(30,8, utf8_decode($totfrai),1,0,"C",true);
    $pdf->SetFillColor(177,254,152);
    $pdf->Cell(20,8, utf8_decode($ligne["mt_peage"]),1,0,"C",true);
    $pdf->Cell(20,8, utf8_decode($ligne["mt_repas"]),1,0,"C",true);
    $pdf->Cell(34,8, utf8_decode($ligne["mt_hebergement"]),1,0,"C",true);
    $pdf->SetFillColor(133,241,238); 
    $pdf->Cell(16,8, utf8_decode($ligne["mt_total"]),1,1,"C",true);
    $pdf->SetFillColor(177,254,152);
}
$pdf->SetX(8);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(178, 8, utf8_decode("Montant total des frais de déplacement"), 1,0,"C");
$pdf->SetFont('Times', '', 9);
$pdf->SetFillColor(133,241,238); 
$pdf->Cell(21,8, utf8_decode($final),1,1,"C",true);


// Licence
$pdf->Ln(5); // saut de ligne
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(80,10,utf8_decode('Je suis licencié sous le n° de licence suivant:'),0,0,'L');
$pdf->Ln(8);

$pdf->SetFont('Times', '', 11);
$pdf->SetFillColor(177,254,152);
$pdf->Cell(0,9,utf8_decode('Licence n° '.$adherent["nr_licence"]),0,1,'C',true);

$pdf->Ln(8); // saut de ligne

//Montant dons
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(80,10,utf8_decode('Montant total des dons'),0,0,'L');
$pdf->SetFont('Times', '', 11);
$pdf->SetFillColor(177,254,152);
$pdf->Cell(0,10,utf8_decode($final),0,0,'C',true);


$pdf->Ln(10); // saut de ligne

$pdf->SetFont('Times', 'I', 11);
$pdf->Cell(80,10,utf8_decode('Pour bénéficer du reçu de dons. Cette note de frais doit être acompagnée de toutes les justificatifs correpondants'),0,0,'L');

//Footer 
$pdf->Ln(12); // saut de ligne
$pdf->SetFont('Times', '', 11);
$pdf->Cell(50,10,utf8_decode('A'),0,0,'C');
$pdf->SetFillColor(177,254,152);
$pdf->Cell(40,9,utf8_decode(''),0,0,'C',true);

$pdf->Cell(50,10,utf8_decode('Le'),0,0,'C');
$pdf->SetFillColor(177,254,152);
$pdf->Cell(40,9,utf8_decode(''),0,0,'C',true);

$pdf->Ln(10); // saut de ligne

$pdf->Cell(50,10,utf8_decode('Signature du bénévole'),0,0,'C');
$pdf->SetFillColor(177,254,152);
$pdf->Cell(40,9,utf8_decode(''),0,0,'C',true);
$pdf->Ln(20);
// Encadré réservée à l'association
$pdf->SetFillColor(245,129,182);
$pdf->SetFont('Times', 'B', 11);
$pdf->MultiCell(90, 10, utf8_decode("Partie réservée à l'association"),0,'C',true);
$pdf->SetFont('Times', '', 11);
$pdf->MultiCell(90, 10, utf8_decode("N° d'ordre du Reçu : ".$note["nr_ordre"]),0,1,'L',true);
$pdf->MultiCell(90, 10, utf8_decode("Remis le :"),0,1,'L',true);
$pdf->MultiCell(90, 10, utf8_decode("Signature du Trésorier :"),0,1,'L',true);

// Génération du document PDF dans le dossier outfiles
$pdf->Output('outfiles/notes_frais.pdf','f');  // f=fichier local
//header('Location: notes_frais.php');
?>

    </body>
</html>