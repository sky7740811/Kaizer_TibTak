<?php

session_start();
include('fonctions.php');
$login = customHeader('Accueil');
include('connect.php');
?>
<p style="margin-left: 20%; font-size: 20px">Bienvenue sur notre site covoiturage</p>

<?php customFooter() ?>