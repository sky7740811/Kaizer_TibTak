<?php
session_start();
include('fonctions.php')
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Création d'un compte</title></head>
    <link rel="stylesheet" type="text/css" href="base.css" media="all" />
    <body>

        <?php
        //Verification si l'utlisateur est deja identifié
        if (!empty($_SESSION['login'])) {
            header('location:accueil.php');
        }
        ?>

        <h1 style="text-align: center;margin-top: 0px;">Créer votre compte</h1>
        <fieldset style="margin: auto;">
            <?php action("post", "creer_compte.php"); ?>

            <label>Nom</label>
            <input type="text" name="nom"/>
            <p/>
            <label>Prenom</label>
            <input type="text" name="prenom"/>
            <p/>
            <label>Date de naissance(sous forme jjmmaa ex. 7 juin 1994 : 070694)</label>
            <input type="text" name="datenaissance" maxlength="6" minlength="6"/>
            <p/>
            <label>Login</label>
            <input type="text" name="login"/>
            <p/>
            <label>Mot de passe</label>
            <input type="password" name="mdp" minlength="4" maxlength="20"/>
            <p/>
            <label>Confirmation mot de passe</label>
            <input type="password" name="confirm_mdp" minlength="4" maxlength="20"/>
            <p/>
            <label>Photo</label>
            <input type="file" name="photo" /><p/>
            <input type="submit" name= "submit" value="Valider"/>
            <input type="reset" value="Effacer"/>

            <p/>
        </form>
        <?php
        include('connect.php');

        $error_msg = "";
        if (isset($_POST['submit']) && $_POST['submit'] == 'Valider') {
            if (!isset($_POST['nom']) || empty($_POST['nom'])) {
                $error_msg .= "Veuillez indiquer votre nom.<br />\n";
            } else {
                $nom = $_POST['nom'];
            }

            if (!isset($_POST['prenom']) || empty($_POST['prenom'])) {
                $error_msg .= "Veuillez indiquer votre prénom.<br />\n";
            } else {
                $prenom = $_POST['prenom'];
            }

            if (!isset($_POST['datenaissance']) || empty($_POST['datenaissance'])) {
                $error_msg .= "Veuillez indiquer votre date de naissance (jjmmaa).<br />\n";
            } else {
                $datenaissance = $_POST['datenaissance'];
            }

            if (!isset($_POST['login']) || empty($_POST['login'])) {
                $error_msg .= "Veuillez indiquer un login.<br />\n";
            } else {
                $exist_login = "select distinct login from compte where login = '" . $_POST['login'] . "'";
                $resultat_login = mysqli_query($db, $exist_login);
                $logindansbd = mysqli_fetch_row($resultat_login)[0];
                if ($logindansbd == $_POST['login']) {
                    $error_msg .= "Veuillez indiquer un autre login, celui-ci existe déjà.<br />\n";
                } else {
                    $login = $_POST['login'];
                }
            }

            if (isset($_POST['mdp']) && !empty($_POST['mdp']) && isset($_POST['confirm_mdp']) && !empty($_POST['confirm_mdp'])) {
                if ($_POST['mdp'] != $_POST['confirm_mdp']) {
                    $error_msg .= "Les mots de passe ne correspondent pas.<br />\n";
                } else {
                    $mdp = $_POST['mdp'];
                }
            } else {
                $error_msg .= "Vous devez indiquer deux mots de passe identiques.<br />\n";
            }

            if (isset($_FILES['photo']) && !empty($_FILES['photo']["tmp_name"])) {
                $target_dir = "./images/";
                $target_file = $target_dir . basename($_FILES['photo']["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                
                $check = getimagesize($_FILES['photo']["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $error_msg .= "Photo : Ce fichier n'est pas une image.<br />\n";
                    $uploadOk = 0;
                }

                if ($_FILES['photo']["size"] > 500000) {
                    $error_msg .= "Photo : veuillez choisir une image moins volumineuse.<br />\n";
                    $uploadOk = 0;
                }

                if ($imageFileType != "png") {
                    $error_msg .= "Photo : Seule l'extension .png est supportée.<br />\n";
                    $uploadOk = 0;
                }

                if ($uploadOk == 0) {
                    $error_msg .= "Erreur dans le téléchargement de la photo.<br />\n";
                } else {
                    if (move_uploaded_file($_FILES['photo']["tmp_name"], $target_file)) {
                        $error_msg == "Photo uploadée.<br />\n";
                        $nomphoto = $_FILES['photo']["name"];
                    } else {
                        $error_msg .= "Erreur dans le téléchargement de la photo.<br />\n";
                        $nomphoto = 'default.png';
                    }
                }
            } else {
                $nomphoto = 'default.png';
            }

            if ($error_msg == "") {
                $insert = "Insert into compte
                                Values 
                                (  
                                    '',
                                    '" . $nom . "',
                                    '" . $prenom . "',
                                    '" . $datenaissance . "',
                                    '" . $login . "',
                                    '" . $mdp . "',
                                    '0',
                                    '" . $nomphoto . "',
                                    ''
                                )";
                $resultat_insert = mysqli_query($db, $insert);

                if ($resultat_insert) {
                    setcookie('error_msg', "");
                    js("alert('Compte créé.')");
                    js("document.location.href = 'Login.php'");
                } else
                    echo (mysqli_error($db));
            } else {
                echo $error_msg;
                //js("alert('Au moins un champ est vide')");
            }
        }
        ?>

    </fieldset>
</body>
</html>