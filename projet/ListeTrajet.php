<?php 
session_start(); 
include('fonctions.php');
$login = customHeader('Liste des trajets');
include('connect.php');

$select1 = "select      ville1.nom as Ville_Depart,
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
                    trajet.nb_place_dispo > 0;
            "
;

$resultat1 = mysqli_query($db, $select1);
if (!$resultat1)
    echo (mysqli_error($db));

$tab1 = array();

while ($row = mysqli_fetch_assoc($resultat1)) {
    $tab1[] = $row;
}
// $tab1 = mysqli_fetch_array($resultat);
//$tab11 = array($tab1[0],$tab1[1],$tab1[2],$tab1[3],$tab1[4],$tab1[5],$tab1[6],$tab1[7]);
//tab[0] = id_v tab[1] id_c tab[2] marque tab[3] modele tab[4]=couleur tab[5] nb place dispo tab[6]=annee
// print_r($tab1);
listTrajet($tab1,1);

customFooter();
?>