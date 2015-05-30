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

action('post', 'SelectTrajet.php');
echo ("<fieldset style= margin : auto>");
echo ("<legend>Rechercher par critères</legend>");
echo ("<label>Ville Départ  </label>");
echo ("<select name='ville_dep'>");
foreach ($tab_ville as $ville) {
    echo "<option>$ville</option>";
}
echo ("</select><p/>");

echo ("<label>Ville Arrivée </label>");
echo ("<select name='ville_arriv'>");
foreach ($tab_ville as $ville) {
    echo "<option>$ville</option>";
}
echo ("</select><p/>");

echo ("<label>Date départ   </label>");
echo ("<input type='text' name='date_dep'/><p/>");
echo ("<input type='submit' name='recherche' value='Rechercher'/>");
echo("</form></fieldset>");

if (isset($_POST['submit'])) {
    if ($_POST['ville_dep'] == $_POST['ville_arriv']) {
        js("alert('La ville de départ et la ville d\'arrivée doivent être différentes')");
        js("document.location.href = 'SelectTrajet.php'");
    } else {
        $date_dep = '';
        if (!empty($_POST['date_dep'])) {
            $date_dep = " and trajet.date_dep = '" . $_POST['date_dep'] . "'";
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
                                        vehicule.id_c = compte.id_c and
                                        trajet.isEffectue = 0 and
                                        trajet.nb_place_dispo > 0 and
                                        ville1.nom = '" . $_POST['ville_dep'] . "' and
                                        ville2.nom = '" . $_POST['ville_arriv'] . "'"
                . $date_dep . "
                                    "
        ;

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

        listTrajet($tab2);
    }
}
?>

<?php customFooter() ?>