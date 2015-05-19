<?php 
session_start(); 
include('fonctions.php');
$login = customHeader('Covoiturage', 'base.css');
include('connect.php');

$select = 
            "
             select *
             from compte
            "
;
$resultat = mysqli_query($db, $select);

while($row = mysqli_fetch_assoc($resultat)) {
    $tab1[]=$row;
}

echo "<table border=1>
        <tr>
            <th>Numero de compte</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Date de naissance</th>
            <th>Identifiant</th>
            <th>Mot de passe</th>
            <th>Argent</th>
            <th>IsAdmin</th>
        </tr>";

foreach ($tab1 as $key => $value) {
    echo    "   <tr>
                    <td>" . ($tab1[$key]['id_c']) . "</td>
                    <td>" . $tab1[$key]['nom'] . "</td>
                    <td>" . $tab1[$key]['prenom'] . "</td>
                    <td>" . $tab1[$key]['datenaissance'] . "</td>
                    <td>" . $tab1[$key]['login'] . "</td>
                    <td>" . $tab1[$key]['mdp'] . "</td>
                    <td>" . ($tab1[$key]['argent']) . "</td>
                    <td>" . ($tab1[$key]['isAdmin']) . "</td>
                </tr>";
}
echo "</table></form>";

customFooter();
?>