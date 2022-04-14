<?php
include 'sql.php';
session_start();

// Requete pour afficher la période
$sql = "select * from periode where est_active='1'";
try {
  $sth = $dbh->prepare($sql);

  $sth->execute();
  $periode = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 1: " . $e->getMessage() . "</p>");
}

// Requete pour afficher le nom et prénom du user
$sql = "select * from utilisateur where id_utilisateur = :id_utilisateur";
try {
  $sth = $dbh->prepare($sql);

  $sth->execute(array(
  ":id_utilisateur" => $_SESSION["user"]["id_utilisateur"]
));
  $utilisateur = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 2: " . $e->getMessage() . "</p>");
}






$sql='SELECT utilisateur.id_utilisateur, pseudo, mdp, mail, nom, prenom, role ,id_adherent, nr_licence, adherent.adr1, adherent.adr2, adherent.adr3, club.id_club , lib_ligue, lib_club, club.adr1, club.adr2, club.adr3, ligue.id_ligue FROM ligue ,club ,utilisateur ,adherent WHERE ligue.id_ligue=club.id_ligue AND adherent.id_club=club.id_club and adherent.id_utilisateur=utilisateur.id_utilisateur and utilisateur.id_utilisateur=:id_utilisateur GROUP by utilisateur.id_utilisateur;';

try {
  $sth = $dbh->prepare($sql);

  $sth->execute(array( 
    ":id_utilisateur" => $_SESSION["user"]["id_utilisateur"]
));
  $ligue1 = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 3: " . $e->getMessage() . "</p>");
}


// Requete pour afficher l'adresse du user
$sql = 'select utilisateur.id_utilisateur, pseudo, mdp, mail, nom, prenom, role ,id_adherent, nr_licence, adr1, adr2, adr3,  id_club from adherent ,utilisateur where adherent.id_utilisateur=utilisateur.id_utilisateur and utilisateur.id_utilisateur=:id_utilisateur;';

try {
  $sth = $dbh->prepare($sql);

  $sth->execute(array( 
    ":id_utilisateur" => $_SESSION["user"]["id_utilisateur"]
));
  $adherent = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 4: " . $e->getMessage() . "</p>");
}

// Requete pour afficher le tableau
$sql = 'select * from ligne, note, motif where ligne.id_note=note.id_note and id_utilisateur=:id_utilisateur and motif.id_motif = ligne.id_motif';

try {
  $sth = $dbh->prepare($sql);

  $sth->execute(array( 
    ":id_utilisateur" => $_SESSION["user"]["id_utilisateur"]
));
  $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 5: " . $e->getMessage() . "</p>");
}

// Requete pour afficher l'adresse des clubs
$sql = 'select lib_club, club.adr1 as adr1, club.adr2 as adr2, club.adr3 as adr3 from club ,adherent where adherent.id_club=club.id_club and id_utilisateur=:id_utilisateur';
echo($sql);
try {
  $sth = $dbh->prepare($sql);

  $sth->execute(array( 
    ":id_utilisateur" => $_SESSION["user"]["id_utilisateur"]
));
  $club = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 6: " . $e->getMessage() . "</p>");
}

// Requete license
$sql = "select * from adherent where id_utilisateur = :id_utilisateur";
try {
  $sth = $dbh->prepare($sql);

  $sth->execute(array(
  ":id_utilisateur" => $_SESSION["user"]["id_utilisateur"]
));
  $utilisateurs = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 7: " . $e->getMessage() . "</p>");
}

// Requete num ordre recu
$sql = "select * from note where id_utilisateur = :id_utilisateur";
try {
  $sth = $dbh->prepare($sql);

  $sth->execute(array(
  ":id_utilisateur" => $_SESSION["user"]["id_utilisateur"]
));
  $note = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 8: " . $e->getMessage() . "</p>");
}


// Requete num ordre recu
$sql = "SELECT sum(mt_total) as sum_montant from note where id_utilisateur=:id_utilisateur group by id_utilisateur";
try {
  $sth = $dbh->prepare($sql);

  $sth->execute(array(
  ":id_utilisateur" => $_SESSION["user"]["id_utilisateur"]
));
  $montant = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 9: " . $e->getMessage() . "</p>");
}

$sql = "SELECT ligue.id_ligue, ligue.lib_ligue, club.id_club, club.lib_club FROM club, ligue, motif WHERE ligue.id_ligue = club.id_ligue GROUP by id_club";
try {
  $sth = $dbh->prepare($sql);
  $sth->execute();
  $club1 = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL 10: " . $e->getMessage() . "</p>");
}

// Requete cumul des frais 
$sql = "SELECT ligue.lib_ligue AS NomLigue, club.lib_club AS NomClub, motif.lib_motif AS NomMotif, periode.lib_periode AS Periode, SUM(ligne.mt_total) AS MtPeriode
FROM note,periode,club,adherent,motif,ligue,ligne
WHERE periode.est_active=1
AND ligne.id_note=note.id_note
AND ligne.id_motif=motif.id_motif
AND periode.id_periode=note.id_periode
AND note.id_utilisateur=adherent.id_utilisateur
AND adherent.id_club=club.id_club
AND club.id_ligue=ligue.id_ligue
GROUP BY NomLigue,NomClub,NomMotif;";
try {
  $sth = $dbh->prepare($sql);
  $sth->execute();
  $cumuls = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}

?>

