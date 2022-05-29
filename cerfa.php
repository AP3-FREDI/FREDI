<?php

/**
 * po27b : liste des pays
 */
require_once "init.php";
require_once "fpdf/fpdf.php";
require_once "function/pdf_requete.php";
require_once "function/function.php";
// Crée le tableau d'objets métier "Pays"



$pdf = new FPDF();
$pdf->SetTitle('PDF', true);
$pdf->SetAuthor('dd', true);
$pdf->SetSubject('cerfa', true);
$pdf->mon_fichier = "cerfa.pdf";

$pdf->AddPage();

$pdf->Image('img\CERFA_vierge.png', 0, 0, 210, 300);
$pdf->setY(18);
$pdf->setX(165);

$pdf->SetFont('Times', '', 8);
$pdf->SetTextColor(0, 0, 0); // Noir
$pdf->SetFont('', 'B');
//NM ORDRE DE RECU
$pdf->SetFillColor(255,255,255);
$pdf->Cell(25, 5, utf8_decode($lignes['0']['nr_ordre']),  0, "R", true);

//NOM OU DENOMINATION
$pdf->setY(37);
$pdf->Cell(25, 3, utf8_decode($club['lib_club']),  0, "R", true);
//CODE ADRESSE
//N°

$numero =preg_match_all('!\d+!', $club['adr1'], $matches);
$pdf->setY(46);
$pdf->setX(20);
$pdf->Cell(5, 3, utf8_decode($numero),  0, "R", true);
//CODE ADRESSE
//RUE
 
$adresse= preg_replace('/\-?\d+/', '', $club['adr1']);

$pdf->setY(46);
$pdf->setX(55);
$pdf->Cell(16, 3, utf8_decode($adresse),  0, "R", true);
//CODE POSTAL
$pdf->setY(52);
$pdf->setX(30);
$pdf->Cell(13, 3, utf8_decode($club['adr2']),  0, "R", true);
//COMMUNE
$pdf->setY(52);
$pdf->setX(80);
$pdf->Cell(17, 3, utf8_decode($club['adr3']),  0, "R", true);
//OBJET

echo $newphrase= str_replace("Ligue de","Club",$ligue1["lib_ligue"]);


$pdf->setY(61);
$pdf->setX(60);
$pdf->Cell(4, 3, utf8_decode($newphrase),  0, "R", true);
//coche la case 
$pdf->SetTextColor(0, 0, 0);
$pdf->setY(79.8);
$pdf->setX(12);
$pdf->Cell(4, 3,  'X', 0, "R", true);

//$pdf->setY(84.8);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(90.6);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(99.6);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(105.4);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(115.0);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(123.0);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(132.8);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(138.0);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(148.0);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(153.0);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);
//
//$pdf->setY(158.0);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", false);

//donateur
//nom
$pdf->setY(178.0);
$pdf->setX(30);
$pdf->Cell(4, 3,utf8_decode($utilisateur["nom"] .'  '. $utilisateur["prenom"] )  , 0, "R", true);
//adresse
$pdf->setY(187.0);
$pdf->setX(60);
$pdf->Cell(4, 3,utf8_decode($adherent["adr1"]), 0, "R", true);
//code postal
$pdf->setY(193.2);
$pdf->setX(35);
$pdf->Cell(4, 3,utf8_decode($adherent["adr2"]), 0, "R", true);
//commune
$pdf->setY(193.2);
$pdf->setX(100);
$pdf->Cell(4, 3,utf8_decode($adherent["adr3"]), 0, "R", true);
//la somme de 
$pdf->setY(201.50);
$pdf->setX(175);
$pdf->Cell(4, 3, utf8_decode($montant['sum_montant']) , 0, "R", true);
//somme en toute lettres

$ChiffreEnLettre=new ChiffreEnLettre ;

 $saisie = intval($montant['sum_montant']);

$pdf->setY(207.50);
$pdf->setX(100);
$pdf->Cell(4, 3,  $ChiffreEnLettre->Conversion($saisie), 0, "L", true);

//date du paiment

$pdf->setY(215.2);
$pdf->setX(60);
$pdf->Cell(4, 3,  date("d-m-Y"), 0, "R", true);


//Mode de versement
//
//$pdf->setY(158.0);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", true);

//mode versement

//$pdf->setY(232.5);
//$pdf->setX(12);
//$pdf->Cell(4, 3,  'X', 0, "R", true);
//
//$pdf->setY(232.5);
//$pdf->setX(50);
//$pdf->Cell(4, 3,  'X', 0, "R", true);

$pdf->setY(241.0);
$pdf->setX(12);
$pdf->Cell(4, 3,  'X', 0, "R", true);

//

$pdf->Output('f','outfiles/'.$pdf->mon_fichier);
//header('Location: index.php');
 
?>