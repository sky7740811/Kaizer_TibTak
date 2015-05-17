<?php
session_start();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Covoiturage</title></head>
    <body>

<?php
include('fonctions.php');

if(empty($_SESSION['login'])){
    js("alert('Veuillez saisir votre identifiant')");
    js("document.location.href = 'Login.php'");
 }
elseif(empty($_SESSION['mdp'])){
    js("alert('Veuillez saisir votre mot de passe')");
    js("document.location.href = 'Login.php'");
}
else{
include('connect.php');
$login = $_SESSION['login'];
$mdp = $_SESSION['mdp'];

$exist = "select distinct login, mdp
                from compte
                where login = '". $login ."'
                "
                ;
$resultat= mysqli_query($db, $exist);
$tab = mysqli_fetch_array($resultat);  //tab[0] = login , tab[1] = mdp

if(empty($tab)){
    js("alert('Identifiant incorrect')");
    js("document.location.href = 'Login.php'");
    session_destroy();
}
elseif($mdp!=$tab[1]){
    js("alert('Mot de passe incorrect')");
    js("document.location.href = 'Login.php'");
    session_destroy();
}
else{
    header('location:accueil.php');
}
}
?>
  
    </body>
</html>