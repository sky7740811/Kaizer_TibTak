<?php

function menu() {
    echo '<ul>
        <li><a href="Modification.php">Caractériser son compte</a></li>
        <li><a href="infovehicule.php">Information sur le véhicule</a></li>
        <li><a href="AjoutTrajet.php">Ajout d\'un nouveau trajet</a></li>
        <li><a href="DonnerNotes.php">Donner des appréciations</a></li>
        <li><a href="SelectTrajet.php">Sélectionner un trajet</a></li>
        <li><a href="PrepareTrajet.php">Préparation des trajet</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
        </ul>';
}

function menu_admin() {
    echo '<ul>
        <li><a href="ListeCompte.php">Visualisation de la liste des comptes</a></li>
        <li><a href="ListeTrajet.php">Visualisation de la liste des trajets</a></li>
        <li><a href="Modification.php">Caractériser son compte</a></li>
        <li><a href="infovehicule.php">Information sur le véhicule</a></li>
        <li><a href="AjoutTrajet.php">Ajout d\'un nouveau trajet</a></li>
        <li><a href="DonnerNotes.php">Donner des appréciations</a></li>
        <li><a href="SelectTrajet.php">Sélectionner un trajet</a></li>
        <li><a href="PrepareTrajet.php">Préparation des trajet</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
        </ul>';
}

?>