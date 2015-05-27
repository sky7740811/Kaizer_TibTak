<?php
session_start();
include('fonctions.php');
$login = customHeader('Liste des trajets');
include('connect.php');
?>

<?php
$mdp = $_SESSION['mdp'];
include('connect.php');
$exist = "select distinct nom,prenom,datenaissance from compte where login='" . $login . "'";
$resultat = mysqli_query($db, $exist);
$tab = mysqli_fetch_array($resultat);  //tab[0] = nom , tab[1] = prenom, tab[2] = datenaissance
$nom = $tab[0];
$prenom = $tab[1];
$datenaissance = $tab[2];
?>  
<fieldset style="margin: auto;">
    <legend>Caractéristiques du compte</legend>
    <?php
    action("post", "Modification.php");

    echo "<p>\n";
    echo "<label>Nom</label> <input type='text' value='$nom' name='nom'/>\n";
    echo "</p>";

    echo "<p>\n";
    echo "<label>Prénom</label> <input type='text' value='$prenom' name='prenom'/>\n";
    echo "</p>\n";

    echo "<p>\n";
    echo "<label>Date de naissance(sous forme jjmmaa, ex. 7 juin 1994 : 070694)</label> <input type='text' value='$datenaissance' name='datenaissance' maxlength='6' minlength='6'/>\n";
    echo "</p>\n";

    echo "<p>\n";
    echo "<label>Login</label> <input type='text' name='login' value='$login' disabled='disabled'/>\n";
    echo "</p>\n";

    echo "<p>\n";
    echo "<label>Mot de passe</label> <input type='password' name='mdp' minlength='4' maxlength='20'/>\n";
    echo "</p>\n";

    echo "<p>\n";
    echo "<label>Confirmation mot de passe</label> <input type='password' name='confirm_mdp'/>\n";
    echo "</p>\n";

    echo "<p>\n";
    echo "<label>Photo</label> ";
    echo "<input type='file' name='photo' id='photo' /></p>";
    echo "<input type='submit' name='submit' value='Valider'/>";
    echo "<input type='reset' value='Effacer'/>";
    echo "</form>";
    echo "</fieldset>";


//verification de champs vides
    if (isset($_POST['submit']) && $_POST['submit'] == 'Valider') {
        if ((isset($_POST['nom']) && !empty($_POST['nom'])) && (isset($_POST['prenom']) && !empty($_POST['prenom'])) && (isset($_POST['datenaissance']) &&
                !empty($_POST['datenaissance']))) {
            $newnom = $_POST['nom'];
            $newprenom = $_POST['prenom'];
            $newdate = $_POST['datenaissance'];
            //verification de mots de passe
            if ((isset($_POST['mdp']) && !empty($_POST['mdp']))) {
                if ($_POST['mdp'] != $_POST['confirm_mdp']) {
                    js("alert('Les deux mots de passe sont différents')");
                } else {
                    $newmdp = $_POST['mdp'];
                    $update = "update compte
                            set nom='" . $newnom . "',
                            prenom='" . $newprenom . "',
                            datenaissance='" . $newdate . "',
                            mdp='" . $newmdp . "'
                            where login='" . $login . "'";
                    $resultat_update = mysqli_query($db, $update);

                    if ($resultat_update) {
                        js("alert('Mise à jour réussie.')");
                        js("document.location.href='accueil.php'");
                    } else
                        echo (mysqli_error($db));

                    // header('Location: '.$_SERVER['REQUEST_URI']);
                }
            }

            else {
                $update = "Update compte
                            set nom='" . $newnom . "',
                            prenom='" . $newprenom . "',
                            datenaissance='" . $newdate . "'
                            where login='" . $login . "'
                            "
                ;

                $resultat_update = mysqli_query($db, $update);
                if ($resultat_update) {
                    js("alert('Update successful')");
                    js("document.location.href='accueil.php'");
                } else
                    echo (mysqli_error($db));

                //header('Location: '.$_SERVER['REQUEST_URI']);
            }
        } else
            js("alert('Un de vos champs est vide !')");
    }
    customFooter();
    ?>