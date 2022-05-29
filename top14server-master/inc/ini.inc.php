<?php
//
// top14server - Serveur web service RESTful
//
// fichier commun inclus dans toute les pages

// Racine du site en absolu
define('ROOT', dirname(dirname(__FILE__)));  // Racine du site en absolu

// inclut les équipe du Top14
require_once ROOT."/inc/equipes.inc.php";

// Inclut les fonctions
require_once ROOT."/inc/fonctions.inc.php";

// Inclut les users à authentifier
require_once ROOT."/inc/utilisateurs.inc.php";
 
// Emplacement du fichier des tokens
define("TOKEN_FILENAME",ROOT."/files/tokens.txt");
