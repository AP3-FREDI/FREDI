<?php

$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] :  '';
$mail = isset($_POST['mail']) ? $_POST['mail'] :  '';
$password = isset($_POST['password']) ? $_POST['password'] :  '';
$password2 = isset($_POST['password2']) ? $_POST['password2'] :  '';
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$ligue = isset($_POST['ligue']) ? $_POST['ligue'] : '';
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
$adr1 = isset($_POST['adr1']) ? $_POST['adr1'] : '';
$adr2 = isset($_POST['adr2']) ? $_POST['adr2'] : '';
$adr3 = isset($_POST['adr3']) ? $_POST['adr3'] : '';
$typeutil = isset($_POST['role']) ? $_POST['role'] : '';


$active = 3;
$title = "Inscription";
require('header.php');
$page = $_SERVER['PHP_SELF'];
logToDisk($page, '', '');
include 'sql.php'; ?>

<div class="center">
    <h1>S'inscrire</h1>
    <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table>
            <tr>
                <td><label for="nom">Nom* : </label></td>
                <td><input type="text" id="nom" name="nom" value="<?php echo $nom; ?>"></td>
            </tr>
            <tr>
                <td><label for="prenom">Prénom* : </label></td>
                <td><input type="text" id="prenom" name="prenom" value="<?php echo $prenom; ?>"></td>
            </tr>
            <tr>
                <td><label for="pseudo">Pseudo * <br> au moins 8 char : </label></td>
                <td><input type="text" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>"></td>
            </tr>
            <tr>
                <td><label for="mail">Email* : </label></td>
                <td><input type="text" id="mail" name="mail" value="<?php echo $mail; ?>"></td>
            </tr>
            <tr>
            
                <td><label for="password">Mot de passe* : <br> au moins 8 char , 1  MAJ , un chiffre 1 char special</label></td>
                <td><input type="password" id="password" name="password" value="<?php echo $password; ?>"></td>
            </tr>
            <tr>
                <td><label for="password2">Confirmer le mot de passe* : </label></td>
                <td><input type="password" id="password2" name="password2" value="<?php echo $password2; ?>"></td>
            </tr>
            <td><label for="ligue">Ligue* : </label></td>
            <td>
                <select name="ligue" id="ligue">
                    <option value="1">Ligue de Judo Auvergne-Rhône-Alpes</option>
                    <option value="2">Ligue de footbal de Haute-Garonne</option>
                    <option value="3">Ligue de footbal Aquitaine</option>
                    <option value="4">Ligue de tennis de Corse du Sud</option>
                    <object value="5">Ligue équitation du Var</object>
                    <object value="6">Ligue de natation du Quercy</object>
                </select>
            </td>
            </tr>
            <tr>
                <td><label for="adr1">Adresse* : </label></td>
                <td><input type="text" id="adr1" name="adr1" value="<?php echo $adr1; ?>"></td>
            </tr>
            <tr>
                <td><label for="adr2">Code Postal* : </label></td>
                <td><input type="text" id="adr2" name="adr2" value="<?php echo $adr2; ?>"></td>
            </tr>
            <tr>
                <td><label for="adr3">Ville* : </label></td>
                <td><input type="text" id="adr3" name="adr3" value="<?php echo $adr3; ?>"></td>
            </tr>
            <td>
                <p><a href="connexion.php">Déjà inscrit ?</a></p>
                </body>
            </td>
            <td><input class="button green full" name="submit" type="submit" value="S'inscrire"></td>
            </tr>
            <tr>
                <td colspan=2>
                    <p>* : Champs obligatoires</p>
                </td>
            </tr>
        </table>
    </form>
</div>

<?php


$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] :  '';
$mail = isset($_POST['mail']) ? $_POST['mail'] :  '';
$password = isset($_POST['password']) ? $_POST['password'] :  '';
$password2 = isset($_POST['password2']) ? $_POST['password2'] :  '';
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prenom = isset($_POST['ligue']) ? $_POST['ligue'] : '';
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
$adr1 = isset($_POST['adr1']) ? $_POST['adr1'] : '';
$adr2 = isset($_POST['adr2']) ? $_POST['adr2'] : '';
$adr3 = isset($_POST['adr3']) ? $_POST['adr3'] : '';
$typeutil = isset($_POST['role']) ? $_POST['role'] : '';
$submit = isset($_POST['submit']);

$containsLetter  = preg_match('/[a-zA-Z]/',    $password);
$containsDigit   = preg_match('/\d/',          $password);
$containsSpecial = preg_match('/[^a-zA-Z\d]/', $password);

$containsAll = $containsLetter && $containsDigit && $containsSpecial;
//Si l'user a cliqué sur submit
if ($submit) {
    //Si pseudo sup à 8 carac.
    if (strlen($pseudo) >= 5) {
        //Si mdp sup à 8 carac.
        if (strlen($password) >= 8 && $containsAll == true) {
            //Si 2 mdp identiques
            if ($password == $password2) {
                //Lecture du pseudo et du mail dans la BDD pour comparer si ceux-ci existent déjà ou non
               
                try {
                    $sth = $dbh->prepare("SELECT * FROM utilisateur ");
                    $sth->execute();
                    $users = $sth->fetchAll(PDO::FETCH_ASSOC);
                    //Gestion des erreurs
                } catch (PDOException $ex) {
                    die("Erreur lors de la requête SQL : " . $ex->getMessage());
                }
                //Si le mail ou le pseudo n'existe pas déjà alors on peut s'inscrire
                $verifmail=0 ;
                $verifpseudo=0 ;

                foreach ($users as $user){

                 if($user['mail'] == $mail){

                    $verifmail=1 ;
                 }
                 if($user['pseudo'] ==$pseudo){

                    $verifpseudo=1 ;
                 }

                }
                if ( $verifmail == 0 || $verifpseudo == 0 ) {
                    //On crypte le mdp
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    //On insère les champs saisis dans la BDD avec la requête SQL


                    try {        //insertion de l'utilsateur   
                        $req = $dbh->prepare('INSERT INTO utilisateur(pseudo, mdp, mail,nom,prenom ) VALUES(:pseudo ,:mdp ,:mail ,:nom,:prenom)');
                        $req->execute(array(
                            ':nom' => $nom,
                            ':prenom' => $prenom,
                            ':mdp' => $password,
                            ':mail' =>   $mail,
                            ':pseudo' => $pseudo

                        ));


                    } catch (PDOException $ex) {
                        die("Erreur lors de la requête SQL : " . $ex->getMessage());
                    }


                    //affichage du tableau
                    try {
                        $requser = $dbh->prepare("SELECT * FROM utilisateur WHERE mail = :mail");
                        $requser->execute(array(":mail" => $mail));
                        $userinfo = $requser->fetch();
                    } catch (PDOException $e) {
                        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
                    }
                    try {
                        $req = $dbh->prepare('INSERT INTO  adherent (adr1 ,adr2 ,adr3 ,id_utilisateur,id_club)VALUES (:adr1 ,:adr2 ,:adr3,:id_utilisateur,:id_club) ');
                        $req->execute(array(
                            ':adr1' => $adr1,
                            ':adr2' => $adr2,
                            ':adr3' => $adr3,
                            ':id_utilisateur' => $userinfo['id_utilisateur'],
                            ':id_club' => $ligue
                        ));
                        //  echo 'enregistrement effectué !';
                        // header('Location:connexion.php');
                    } catch (PDOException $ex) { //gestion des erreurs
                        die("Erreur lors de la requête SQL : " . $ex->getMessage());
                    }

                    $_SESSION['messages'] = array(
                        "inscription" => ["green", "Vous vous êtes bien inscrit !"]
                    );

                    header("Location: connexion.php");
                } //Conditions où la connexion échoue
                else {
                    $_SESSION['messages'] = array("Password" => ["red", "Cet utilisateur ou mail existe déjà."]);
                }
            } else {
                $_SESSION['messages'] = array("Password" => ["red", "Les mots de passe ne sont pas identiques"]);
            }
        } else {
            $_SESSION['messages'] = array("Password" => ["red", "Vous avez rentré un mot de passe trop court ou qui ne contient pas de chiffre ou de lettre ou qui ne contient pas de majuscule"]);
        }
    } else {
        $_SESSION['messages'] = array("Pseudo" => ["red", "Vous avez rentré un pseudo trop court"]);
    }
} else {
}


?>