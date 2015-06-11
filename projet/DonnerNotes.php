<?php

session_start();
include('fonctions.php');
$login = customHeader("Donner des appréciations");
include('connect.php');
?>

<?php

$select_notes_restantes = "select 
                                    notes.note,
                                    notes.id_donneur,
                                    notes.id_receveur,
                                    notes.id_trajet,
                                    ville1.nom as ville_dep,
                                    ville2.nom as ville_arriv,
                                    trajet.date_dep as date_dep,
                                    trajet.heure_dep as heure_dep,
                                    compte.nom as nom,
                                    compte.prenom as prenom
                                    
                                    from notes, compte, trajet
                                    join ville ville1 on trajet.ville_dep = ville1.id_ville
                                    join ville ville2 on trajet.ville_arriv = ville2.id_ville
                                    where id_donneur in (select id_c from compte where login = '" . $login . "')
                                    and compte.id_c = id_receveur
                                    and notes.note IS NULL";

$resultat_notes_restantes = mysqli_query($db, $select_notes_restantes);
if (!$resultat_notes_restantes)
    echo (mysqli_error($db));

$tab_notes = array();

while ($row = mysqli_fetch_assoc($resultat_notes_restantes)) {
    $tab_notes[] = $row;
}

donnerNotes($tab_notes);
?>

<?php customFooter() ?>