<?php

function login($login){
//verification si on essaye d'acceder a cette page sans login
    if(empty($login)){
        HEADER('location:Login.php');
    }
}

function action($method,$action){
        echo "<form method='". $method ."' action='". $action . "'>";
}

function js($text){
    echo "<script type='text/javascript'>" . $text . "</script>";
}

function listAnnee($deban,$nban,$anneeSelect){ //debut annee, nombre annee
    echo "<select name='annee'>";
        for($i=0;$i<=$nban;$i++){
            echo "<option ";
			if ($anneeSelect!= 0 && ($anneeSelect == $deban+$i)){
				echo "selected='selected'";
			echo " >" . ($deban+$i) . "</option>";
                        }
                        else echo " >" . ($deban+$i) . "</option>";
        }
    echo "</select><p/>";
}

function listNbPlace($select){ //debut annee, nombre annee
    
        for($i=1;$i<=9;$i++){
            echo "<option "; 
                if ($select!= 0 && ($select == $i)){
                    echo "selected='selected'";
                    echo " >" . $i . "</option>";
                }
                else echo ">" . $i . "</option>";
        }
    echo "</select><p/>";
}

function listHeure(){
    echo " <select name='heure_dep'>";
    for($i = 0; $i <=23; $i++){
        if($i<10){
        echo "<option>0" . ($i) . "</option>";
        }
        else echo "<option>" . ($i) . "</option>";
    }
    echo "</select>
          h<p/>";
}

function listVille($tab){
   foreach($tab as $ville){
        echo "<option>".$ville."</option>";
   }
   echo "</select><p/>";
}

function listTrajet($tab1){
    action('post','SelectTrajet2.php');
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
    
    foreach($tab1 as $key=>$value){
        echo "<input type='hidden' name='id_t".$key."' value = '".$tab1[$key]['id_t']."'/>";
        echo "<tr>
                <td>".$tab1[$key]['prenom']." ".$tab1[$key]['nom']."</td>
                <td>".$tab1[$key]['Ville_Depart']."</td>
                <td>".$tab1[$key]['Ville_Arrivee']."</td>
                <td>".$tab1[$key]['date_dep']." à ".$tab1[$key]['heure_dep']."h</td>
                <td>".$tab1[$key]['marque']." ".$tab1[$key]['modele']."</td>
                <td>".($tab1[$key]['nb_place_dispo'])."</td>
                <td>".$tab1[$key]['prix']."</td>
                <td><input type = 'submit' name ='select".$key."' value='Réserver'/></td>
                </tr>";
    }
    echo "</table></form>";
}

function PreparerTrajet($tab1){
    action('post','PrepareTrajet2.php');
    echo "<table border=1>
                <tr>
                    <th>Ville Départ</th>
                    <th>Ville Arrivée</th>
                    <th>Date départ</th>
                    <th>Nombre de places disponibles</th>
                    <th>prix</th>
                    <th></th>
                </tr>";
    
    foreach($tab1 as $key=>$value){
        
        echo "<input type='hidden' name='id_t".$key."' value = '".$tab1[$key]['id_t']."'/>"; //pour recuperer trajet correspondant
        echo "<input type='hidden' name='prix".$key."' value = '".$tab1[$key]['prix']."'/>"; // --------- prix ---------
        echo "<tr>
                <td>".$tab1[$key]['Ville_Depart']."</td>
                <td>".$tab1[$key]['Ville_Arrivee']."</td>
                <td>".$tab1[$key]['date_dep']." à ".$tab1[$key]['heure_dep']."h</td>
                <td>".($tab1[$key]['nb_place_dispo'])."</td>
                <td>".$tab1[$key]['prix']."</td>
                <td><input type = 'submit' name ='valider".$key."' value='Valider'/>
                <input type = 'submit' name ='supprimer".$key."' value='Supprimer'/></td>
                </tr>";
    }
    echo "</table></form>";
}

function comptepassagers(){
    
}

function verifadmin($login){
    include('connect.php');
    include('menu.php');
    $verif = "  select isAdmin
                from compte
                where login = '".$login."'
            "
    ;
    $result_verif = mysqli_query($db, $verif);
    $admin = mysqli_fetch_array($result_verif);
    if($admin[0]==0){
        menu();
    }
    else{
        menu_admin();
    }
            
}