<?php

session_start();
include('fonctions.php');
$login = customHeader("Sélection d'un trajet");
include('connect.php');
?>

<?php

include('connect.php');

//Rechercher
$select0 = "
                                    select nom
                                    from ville
                                    order by nom
                                "
;
$list_ville = mysqli_query($db, $select0);
while ($ligne = mysqli_fetch_assoc($list_ville)) {
    $tab_ville[] = $ligne['nom'];
}

$select_id_compte = "select id_c from compte where login = '" . $login . "'";
$resultat_id_compte = mysqli_query($db, $select_id_compte);
$tab = mysqli_fetch_array($resultat_id_compte);
$id_compte = $tab[0];

action('post', 'SelectTrajet.php');
echo ("<fieldset style= margin : auto>");
echo ("<legend>Rechercher par critères</legend>");
echo ("<label>Ville Départ  </label>");
echo ("<select name='ville_dep'>");
echo "<option>(vide)</option>";
foreach ($tab_ville as $ville) {
    echo "<option>$ville</option>";
}
echo ("</select><p/>");

echo ("<label>Ville Arrivée </label>");
echo ("<select name='ville_arriv'>");
echo "<option>(vide)</option>";
foreach ($tab_ville as $ville) {
    echo "<option>$ville</option>";
}
echo ("</select><p/>");

echo ("<label>Date départ   </label>");
echo ("<input type='text' name='date_dep'/><p/>");
echo ("<input type='submit' name='recherche' value='Rechercher'/>");
echo("</form></fieldset>");

if (isset($_POST['recherche'])) {
    if ($_POST['ville_dep'] == "(vide)" && $_POST['ville_arriv'] == "(vide)") {
        js("alert('Veuillez sélectionner au moins une ville de départ et/ou une ville d\'arrivée')");
        js("document.location.href = 'SelectTrajet.php'");
    }
    else if ($_POST['ville_dep'] == $_POST['ville_arriv']) {
        js("alert('La ville de départ et la ville d\'arrivée doivent être différentes')");
        js("document.location.href = 'SelectTrajet.php'");
    } else {
        $date_dep = '';
        $ville_dep = '';
        $ville_arriv = '';
        if (!empty($_POST['date_dep'])) {
            $date_dep = " and trajet.date_dep = '" . $_POST['date_dep'] . "'";
        }
        if ($_POST['ville_dep'] != '(vide)') {
            $ville_dep = " and ville1.nom = '" . $_POST['ville_dep'] . "'";
        }
        if ($_POST['ville_arriv'] != '(vide)') {
            $ville_arriv = " and ville2.nom = '" . $_POST['ville_arriv'] . "'";
        }

        $select2 = "select  ville1.nom as Ville_Depart,
                                        ville2.nom as Ville_Arrivee,
                                        compte.nom, 
                                        compte.prenom,
                                        trajet.date_dep, 
                                        trajet.heure_dep, 
                                        trajet.nb_place_dispo, 
                                        trajet.prix,
                                        vehicule.marque,
                                        vehicule.modele,
                                        trajet.id_t

                                        from compte, vehicule, trajet
                                        join ville ville1 on trajet.ville_dep = ville1.id_ville
                                        join ville ville2 on trajet.ville_arriv = ville2.id_ville
                                        where   trajet.id_conducteur = compte.id_c and 
                                        not trajet.id_conducteur = '" . $id_compte . "' and
                                        vehicule.id_c = compte.id_c and
                                        trajet.isEffectue = 0 and
                                        trajet.nb_place_dispo > 0 " 
                                        . $ville_dep 
                                        . $ville_arriv 
                                        . $date_dep . "";

        $resultat2 = mysqli_query($db, $select2);
        if (!$resultat2)
            echo (mysqli_error($db));

        $tab2 = array();

        while ($row = mysqli_fetch_assoc($resultat2)) {
            $tab2[] = $row;
        }
        if (empty($tab2)) {
            js("alert('Trajet non trouv\é')");
            js("document.location.href = 'SelectTrajet.php'");
        }

        listTrajet($tab2,0);
    }
}
?>

<?php customFooter() ?>