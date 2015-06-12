<?php
    
session_start();
include('fonctions.php');
$login = customHeader("Donner des appréciations");

$id_c = $_SESSION['id_c_note'];
$id_t = $_SESSION['id_t_note'];
include('connect.php');

    echo "Quelle note souhaitez-vous donner?";
    action('post','DonnerNotes3.php');
    echo    "<select name='note'>";
    for($i=0; $i<=5; $i++){
        echo    "<option>" . $i . "</option>";
    }
    echo    "</select><p/><input type = 'submit' name = 'submit' value= 'Valider' /></form>";
    
    if (isset($_POST['submit'])) {
        if (isset($_POST['note'])) {

            $update_note1 = "    Update notes Set note = '".$_POST['note']."' 
                                Where   id_receveur = '".$id_c."' and
                                        id_trajet = '".$id_t."'";

            $resultat_update1 = mysqli_query($db, $update_note1);
            if (!$resultat_update1)
                echo (mysqli_error($db));

            $select_avg =   "   Select AVG(note) from notes
                                Where   id_receveur = '".$id_c."'";

            $resultat_avg = mysqli_query($db, $select_avg);
            if (!$resultat_update1)
                echo (mysqli_error($db));
            
            $note_moy = mysqli_fetch_array($resultat_avg);
               
            $update_note2 = "   Update compte Set appreciation = '".$note_moy[0]."' 
                                Where id_c = '".$id_c."'";

            $resultat_update2 = mysqli_query($db, $update_note2);
            if (!$resultat_update2)
                echo (mysqli_error($db));
            
            js("alert('Merci de votre contribution')");
            js("document.location.href = 'accueil.php'");
        }
    }

?>
<?php customFooter() ?>
