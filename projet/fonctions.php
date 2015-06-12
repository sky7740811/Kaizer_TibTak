<?php
function login($login) {
//verification si on essaye d'acceder a cette page sans login
    if (empty($login)) {
        HEADER('location:Login.php');
    }
}

function action($method, $action) {
    echo "<form method='" . $method . "' action='" . $action . "' enctype='multipart/form-data'>";
}

function js($text) {
    echo "<script type='text/javascript'>" . $text . "</script>";
}

function listAnnee($deban, $nban, $anneeSelect) { //debut annee, nombre annee
    echo "<select name='annee'>";
    for ($i = 0; $i <= $nban; $i++) {
        echo "<option ";
        if ($anneeSelect != 0 && ($anneeSelect == $deban + $i)) {
            echo "selected='selected'";
            echo " >" . ($deban + $i) . "</option>";
        } else
            echo " >" . ($deban + $i) . "</option>";
    }
    echo "</select><p/>";
}

function listNbPlace($select) {

    for ($i = 1; $i <= $select; $i++) {
        echo "<option ";
        if ($select != 0 && ($select == $i)) {
            echo "selected='selected'";
            echo " >" . $i . "</option>";
        } else
            echo ">" . $i . "</option>";
    }
    echo "</select><p/>";
}

function listHeure() {
    echo " <select name='heure_dep'>";
    for ($i = 0; $i <= 23; $i++) {
        if ($i < 10) {
            echo "<option>0" . ($i) . "</option>";
        } else
            echo "<option>" . ($i) . "</option>";
    }
    echo "</select>
          h<p/>";
}

function listVille($tab) {
    foreach ($tab as $ville) {
        echo "<option>" . $ville . "</option>";
    }
    echo "</select><p/>";
}

function listTrajet($tab1) {
    action('post', 'SelectTrajet2.php');
    echo "<table border=1>
                <tr>
                    <th>Nom de conducteur</th>
                    <th>Ville Départ</th>
                    <th>Ville Arrivée</th>
                    <th>Date départ</th>
                    <th>Véhicule</th>
                    <th>Nombre de places disponibles</th>
                    <th>prix</th>
                    <th></th>
                </tr>";

    foreach ($tab1 as $key => $value) {
        echo "<input type='hidden' name='id_t" . $key . "' value = '" . $tab1[$key]['id_t'] . "'/>";
        echo "<tr>
                <td>" . $tab1[$key]['prenom'] . " " . $tab1[$key]['nom'] . "</td>
                <td>" . $tab1[$key]['Ville_Depart'] . "</td>
                <td>" . $tab1[$key]['Ville_Arrivee'] . "</td>
                <td>" . $tab1[$key]['date_dep'] . " à " . $tab1[$key]['heure_dep'] . "h</td>
                <td>" . $tab1[$key]['marque'] . " " . $tab1[$key]['modele'] . "</td>
                <td>" . ($tab1[$key]['nb_place_dispo']) . "</td>
                <td>" . $tab1[$key]['prix'] . "</td>
                <td><input type = 'submit' name ='select" . $key . "' value='Réserver'/></td>
                </tr>";
    }
    echo "</table></form>";
}

function PreparerTrajet($tab1) {
    action('post', 'PrepareTrajet2.php');
    echo "<table border=1>
                <tr>
                    <th>Ville Départ</th>
                    <th>Ville Arrivée</th>
                    <th>Date départ</th>
                    <th>Nombre de places disponibles</th>
                    <th>prix</th>
                    <th></th>
                </tr>";

    foreach ($tab1 as $key => $value) {

        echo "<input type='hidden' name='id_t" . $key . "' value = '" . $tab1[$key]['id_t'] . "'/>"; //pour recuperer trajet correspondant
        echo "<input type='hidden' name='prix" . $key . "' value = '" . $tab1[$key]['prix'] . "'/>"; // --------- prix ---------
        echo "<tr>
                <td>" . $tab1[$key]['Ville_Depart'] . "</td>
                <td>" . $tab1[$key]['Ville_Arrivee'] . "</td>
                <td>" . $tab1[$key]['date_dep'] . " à " . $tab1[$key]['heure_dep'] . "h</td>
                <td>" . ($tab1[$key]['nb_place_dispo']) . "</td>
                <td>" . $tab1[$key]['prix'] . "</td>
                <td><input type = 'submit' name ='valider" . $key . "' value='Valider'/>
                <input type = 'submit' name ='supprimer" . $key . "' value='Supprimer'/></td>
                </tr>";
    }
    echo "</table></form>";
}

function donnerNotes($tab_notes) {
    action('post', 'DonnerNotes.php');
    echo "<table border=1>
                <tr>
                    <th>Nom de conducteur</th>
                    <th>Ville de départ</th>
                    <th>Ville d'arrivée</th>
                    <th>Date et heure de départ</th>
                    <th>Personne à noter</th>
                </tr>";
    
    foreach ($tab_notes as $key => $personne) {
        echo "<tr>
                <td>" . $personne['prenom_c'] . " " . $personne['nom_c'] . "</td>
                <td>" . $personne['ville_dep'] . "</td>
                <td>" . $personne['ville_arriv'] . "</td>
                <td>" . $personne['date_dep'] . " à " . $personne['heure_dep'] . "h</td>
                <td>" . $personne['prenom'] . " " . $personne['nom'] . "</td>
                <td><input type = 'submit' name ='noter" . $key . "' value='Noter'/>
                </tr>";
    }
    echo "</table></form>";
}

function comptepassagers() {
    
}

function verifadmin($login) {
    include('connect.php');
    include('menu.php');
    $verif = "  select isAdmin
                from compte
                where login = '" . $login . "'
            "
    ;
    $result_verif = mysqli_query($db, $verif);
    $admin = mysqli_fetch_array($result_verif);
    if ($admin[0] == 0) {
        menu();
    } else {
        menu_admin();
    }
}

function customHeader($title) {
    include('connect.php');
    echo "<!DOCTYPE html>\n";
    echo "<html>\n";
    echo "<head>\n";
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />\n";
    echo "<title>" . $title . "</title>\n";
    echo "<link rel='stylesheet' type='text/css' href='base.css' media='all' />\n";
    echo "</head>\n";
    
    echo "<body>\n";
    $login = $_SESSION['login'];
    login($login);
    if (!isset($_SESSION['photo']) || $_SESSION['photo'] == NULL) {
        $exist = "select distinct photo from compte where login='" . $login . "'";
        $resultat = mysqli_query($db, $exist);
        $tab = mysqli_fetch_array($resultat);
        $photo = $tab[0];
        $_SESSION['photo'] = $photo;
    }
    else $photo = $_SESSION['photo'];
    $argent = "select distinct argent from compte where login='" . $login . "'";
    $resultat = mysqli_query($db, $argent);
    $tab = mysqli_fetch_array($resultat);
    $argent = $tab[0];
    echo "<div id='global'>";
    echo "<div id='entete'>";
    echo "<a href='accueil.php'><img src='accueil.png' height='30'></a>";
    echo "<p class='sous-titre'>";
    echo "Bonjour " . $login . "<br />";
    echo "Vous possédez " . $argent . "€.";
    echo "</p>";
    echo "<img src='images/" . $photo . "' height='128'>";
    echo "</div><!--#entete-->\n";
    echo "<div id='centre'>";
    echo "<div id='navigation'>";
    verifadmin($login);
    echo "</div><!-- #navigation -->";
    echo "<div id='contenu'>";
    return $login;
}

function customFooter() {
    echo "</div><!-- #contenu -->";
    echo "</div><!-- #centre -->";

    echo "<div id='pied'>";
    echo "<p id='copyright'>";
    echo "Mise en page &copy; 2015 Chihoon Lee, Thibault Neulat";
    echo "</p>";
    echo "</div><!-- #pied -->";
    echo "</div><!--#global-->";
    echo "</body>";
    echo "</html>";
}

function verifString($nom, $string, $result) {
    if (!isset($string) || empty($string)) {
        $result += "Le champ " . $nom . " est vide. ";
    }
}