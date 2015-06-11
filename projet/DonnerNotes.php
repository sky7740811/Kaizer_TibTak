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
                                    trajet.ville_dep as ville_dep,
                                    trajet.ville_arriv as ville_arriv,
                                    trajet.date_dep as date_dep,
                                    trajet.heure_dep as heure_dep,
                                    compte.nom as nom,
                                    compte.prenom as prenom
                                    
                                    from notes, trajet, compte
                                    
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