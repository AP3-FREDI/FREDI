<?php
//use :

include '../sql.php';


//phase de teste pour savoir ce que l'on recois 
$insert_get = isset($_GET['insert_get']) ? $_GET['insert_get'] : '';
$login = isset($_GET['login']) ? $_GET['login'] : '';
$action = '';

if ($insert_get != '') {
    $action = 'insert_get';
} else if ($login != '') {
    $action = 'login';
}
$action = 'login';

$result = array('status' => 0, 'msg' => _('Une erreur est survenue.'));

// utiliser pour la cron tab et lancer inactive à la main


if ($action != '') {
$action = 'login';
switch ($action) {

    case 'login':

        $result = array('status' => 0, 'msg' => _('test'));
        $insert_get = isset($_GET['login']) ? $_GET['login'] : '';
        $insert_get = urldecode($insert_get);
        $insert_get = json_decode($insert_get, 1);
        $insert_get[0] = $insert_get;
        $pseudo = 'd.dutertre';
        $password = 'Azertyuiop1234.';
        //On rentre la requête sql dans une variable
        //Lecture du pseudo dans la BDD 
        try {
            $sql = "SELECT * FROM utilisateur WHERE pseudo=:pseudo";
            $sth = $dbh->prepare($sql);
            $sth->execute(array(
                ':pseudo' => $pseudo
            ));
            $user = $sth->fetch(PDO::FETCH_ASSOC);
        } //Gestion des erreurs
        catch (PDOException $ex) {
            die("Erreur lors de la requête SQL : " . $ex->getMessage());
        }
        $result['user'] = $user;
        //Si pseudo et mdp correct alors connecté password_verify compare le mdp saisi avec le mdp crypté dans la BDD
        //    if ($pseudo == $user['pseudo'] && password_verify($password, $user['mdp'])) {
        //détruit la variable mdp
        try {
            $sth = $dbh->prepare('select id_utilisateur from utilisateur where pseudo=:pseudo ');
            $sth->execute(array(":pseudo" => $pseudo));
            $id_utilisateur = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
        $result['id_utilisateur'] = $id_utilisateur;
        try {
            $sth = $dbh->prepare('select id_note from note where id_utilisateur =:id_utilisateur ');
            $sth->execute(array(":id_utilisateur" => $id_utilisateur['id_utilisateur']));
            $id_note = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
        $result['id_note'] = $id_note;
        try {
            $sth = $dbh->prepare('select * from ligne where id_note=:id_note');
            $sth->execute(array(":id_note" => $id_note['id_note']));
            $ligne = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
        $result['ligne'] = $ligne;
        //   } else { // Message d'erreur lorsque les identifiants sont incorrects
        //           $_SESSION['messages'] = array("Account" => ["red", "Ces identifiants sont incorrects"]);
        //   header("Location: connexion.php");
        //      }

        /*
*/
        break;
    case 'insert_get':
        break;
    default:
        break;
}
}
echo json_encode($result);
