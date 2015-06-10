<?php

session_start();
include('fonctions.php');
$login = customHeader('Accueil');
include('connect.php');
?>
<p>Bienvenue sur notre site covoiturage</p>

<?php customFooter() ?>