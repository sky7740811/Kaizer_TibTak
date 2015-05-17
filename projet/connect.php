<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpassword = '';
$dbdatabase = 'projet';

$db = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbdatabase) or 
        die('Impossible de se connecter: ' + mysqli_connect_error());

?>


