<?php session_start(); ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Login</title></head>
    <link rel="stylesheet" type="text/css" href="base.css" media="all" />
    <body>
        <?php
//Verification si l'utlisateur est deja identifié
        if (!empty($_SESSION['login'])) {
            header('location:accueil.php');
        }
        ?>
        <fieldset style="margin-top: 10% ">
            <Legend>Identification</legend>
            <form method="post" action="verifcompte.php">
                <label>Login</label>
                <input type="text" name="login"/>
                <p/>
                <label>Mots de passe</label>
                <input type="password" name="mdp"/>
                <p/>
                <input type="submit" value="Connexion"/>
                <p/>
                <a href="creer_compte.php">Créer un nouveau compte</a>
            </form>
        </fieldset>




    </body>
</html>
