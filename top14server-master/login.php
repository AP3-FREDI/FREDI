<?php
//
// top14server - Serveur web service RESTful
//
// Authentifie un client Android et renvoie une réponse JSON
// Exemple : http://localhost/projets/top14server/login.php?user=jef&password=jefjef
include "inc/ini.inc.php";

// Récupère les paramètres dans l'URL
$user = isset($_GET["user"]) ? $_GET["user"] : "";
$password = isset($_GET["password"]) ? $_GET["password"] : "";

// Vérifie si le user existe
if (isset($users[$user]) && $password == $users[$user]) {
  $message = "user authentifié";
  // Crée un token aléatoire (<PHP7)
  $token = bin2hex(openssl_random_pseudo_bytes(15));
  // Ajoute le token au fichier des tokens
  add_token($token);
} else {
  $message = "user non authentifié";
  $token = null;
}

// Construit le format JSON
$json = build_json($message, $token, NULL);
// Envoie la réponse 
send_json($json);