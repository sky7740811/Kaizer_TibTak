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
echo $nbpassager[0]; //empty if il n'y a eu aucun passager
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


    $update1 = "   update compte set
                                    argent = argent + 10
                                    where id_c in   (  select id_passager
                                                        from participe
                                                        where id_t in   (   select id_t
                                                                            from trajet
                                                                            where id_t  = '" . $id_t . "'
                                                                        )
                                                    )
                                "
    ;
    $resultat_update1 = mysqli_query($db, $update1);

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