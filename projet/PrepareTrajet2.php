<?php

session_start();
include('fonctions.php');
$login = customHeader("Préparation d'un trajet");
include('connect.php');
?>

<?php

$i = -1;
do {
    $i++;
    if (isset($_POST['valider' . $i])) {
        $id_t = $_POST['id_t' . $i]; //numero de trajet choisi par utilisateur
        $prix = $_POST['prix' . $i];
        $validOUsupprim = 'valid'; //verifier si utilisateur veut valider ou supprimer
        break;
    }

    if (isset($_POST['supprimer' . $i])) {
        $id_t = $_POST['id_t' . $i]; //numero de trajet choisi par utilisateur
        $prix = $_POST['prix' . $i];
        $validOUsupprim = 'supprim';
        break;
    }
} while ($i < 100);

//echo $validOUsupprim;
include('connect.php');

$count = "select count(participe.id_passager)
                                from participe, trajet
                                where participe.id_t = trajet.id_t and
                                trajet.id_t = '" . $id_t . "'
                                group by participe.id_t
                            "
;
$result_count = mysqli_query($db, $count);
$nbpassager = mysqli_fetch_array($result_count);
if (empty($nbpassager)) {
    $nbre_passager = 0;
} else {
    $nbre_passager = $nbpassager[0];
}

if ($validOUsupprim == 'valid') {

    //Additionner la somme d'argent gagner par conducteur
    $argent_gagne = ($prix * $nbre_passager);
    $update0 = "update compte set
                                argent = argent + " . $argent_gagne . "
                                where id_c in (select id_conducteur
                                                from trajet
                                                where id_t = '" . $id_t . "'
                                                )
                                "
    ;
    $resultat_update0 = mysqli_query($db, $update0);

    $update1 = "   update trajet set
                                    isEffectue = '1'
                                    where id_t = '" . $id_t . "'
                                "
    ;
    $resultat_update1 = mysqli_query($db, $update1);
    
    $query_passagers = "select * from participe where id_t = '" . $id_t . "'";
    $query_result = mysqli_query($db, $query_passagers);
    $liste_passagers_participants = array();
    while ($row = mysqli_fetch_assoc($query_result)) {
        $liste_passagers_participants[] = $row;
    }
    
    foreach($liste_passagers_participants as $passager) {
        $update2 = "update compte set
                                argent = argent - " . $prix . "
                                where id_c = " . $passager["id_passager"];
        $resultat_update2 = mysqli_query($db, $update2);
    }
    
    js("alert('Trajet Valid\é')");
    js("document.location.href = 'accueil.php'");
} else {
    $argent_perdu = ($nbre_passager * 10);
    $update0 = "update compte set
                                argent = argent - " . $argent_perdu . "
                                where id_c in (select id_conducteur
                                                from trajet
                                                where id_t = '" . $id_t . "'
                                                )
                                "
    ;
    $resultat_update0 = mysqli_query($db, $update0);

    $query_passagers = "select * from participe where id_t = '" . $id_t . "'";
    $query_result = mysqli_query($db, $query_passagers);
    $liste_passagers_participants = array();
    while ($row = mysqli_fetch_assoc($query_result)) {
        $liste_passagers_participants[] = $row;
    }
    
    foreach($liste_passagers_participants as $passager) {
        $update2 = "update compte set
                                argent = argent + 10
                                where id_c = " . $passager["id_passager"];
        $resultat_update2 = mysqli_query($db, $update2);
    }
    
    $delete1 = "   delete from participe 
                                    where id_t = '" . $id_t . "'
                                "
    ;
    $resultat_delete1 = mysqli_query($db, $delete1);

    $delete2 = "   delete from trajet 
                                    where id_t = '" . $id_t . "'
                                "
    ;
    $resultat_delete2 = mysqli_query($db, $delete2);

    js("alert('Trajet Supprim\é')");
    js("document.location.href = 'accueil.php'");
}
?>
<?php customFooter() ?>