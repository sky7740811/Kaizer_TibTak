<?php

session_start();
$_SESSION['login'] = $_POST['login'];
$_SESSION['mdp'] = $_POST['mdp'];
HEADER('Location:verifcompte2.php');




//Pourquoi une page pour simplement démarrer une session ?
/*
  Cela est une sorte de sécurité, en effet, en théorie, rien n’empêche l’utilisateur de directement se connecter en tapant l’URL de la page d’accueil du site une fois loguer ( URL: SiteWeb.php?\Liste.php).
  La session sera démarrée, mais aucune valeurs ne seront dans ‘Login’ et ‘ Password’. Ainsi, grâce à une simple vérification des variables ‘Login’ et ‘Password’ comme vide, Nous saurons si la session est en règle.

  Alors qu’en passant par cette page ( avec la méthode de transmission POST qui cache les variables passées ), nous pourrons affecter les données à la session et ainsi s’assurer que la session est en règle.

  Le HEADER permet de rediriger l’utilisateur une fois que la page a été lu, ainsi cette page est transparente a l’utilisateur. */
?>