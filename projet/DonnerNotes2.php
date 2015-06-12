<?php

session_start();
include('fonctions.php');
$login = customHeader("Donner des appréciations");


$i = -1;
do {
    $i++;
    echo ($_POST['id_c'.$i]);
    if (isset($_POST['noter' . $i])) {
        $id_c = $_POST['id_c' . $i]; //numero de compte choisi par utilisateur
        $id_t = $_POST['id_t' . $i]; //numero de trajet correspondant
    }
} while (!isset($_POST["noter" . $i]));

$_SESSION['id_c_note'] = $id_c;
$_SESSION['id_t_note'] = $id_t;

header('location:DonnerNotes3.php');
?>

<?php

?>

<?php customFooter() ?>