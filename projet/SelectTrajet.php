<?php   session_start();?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Covoiturage</title></head>
    <link rel="stylesheet" type="text/css" href="base.css" media="all" />
    <body>
        
<?php

include('fonctions.php');
$login = $_SESSION['login'];
login($login);
?>
<div id="global">
    <div id="entete">
    
    <a href='accueil.php'><img src='accueil.png' height='30'></a>
		
    
    <p class="sous-titre">
			<?php echo ("Bonjour, $login");?>
		</p>    
    <div id="centre">   
        <div id="navigation">
			<?php include('menu.php');?>
        </div><!-- #navigation -->
         <div id="contenu">

             <?php
                include('connect.php');
                
                //Rechercher
                $select0=    "
                                    select nom
                                    from ville
                                "
                ;
                $list_ville = mysqli_query($db, $select0);
                while($ligne = mysqli_fetch_assoc($list_ville)){
                  $tab_ville[]=$ligne['nom'];  
                }
                
                action('post','SelectTrajet.php');
                echo ("<fieldset style= margin : auto>");
                echo ("<legend>Rechercher par critères</legend>");
                echo ("<label>Ville Départ  </label>");
                echo ("<select name='ville_dep'>");
                foreach($tab_ville as $ville){
                    echo "<option>$ville</option>";
                }
                echo ("</select><p/>");
                
                echo ("<label>Ville Arrivée </label>");
                echo ("<select name='ville_arriv'>");
                foreach($tab_ville as $ville){
                    echo "<option>$ville</option>";
                }
                echo ("</select><p/>");
                
                echo ("<label>Date départ   </label>");
                echo ("<input type='text' name='date_dep'/><p/>");
                echo ("<input type='submit' name='recherche' value='Rechercher'/>");
                echo("</form></fieldset>");
                
                if(!isset($_POST['recherche'])){
                   //Recuperer toutes les trajets disponibles
                    $select1 = "select  ville1.nom as Ville_Depart,
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

                    $resultat1= mysqli_query($db, $select1);
                    if(!$resultat1) echo (mysqli_error($db));

                    $tab1 = array();

                    while($row = mysqli_fetch_assoc($resultat1)){
                      $tab1[]=$row;  
                    }
                   // $tab1 = mysqli_fetch_array($resultat);
                    //$tab11 = array($tab1[0],$tab1[1],$tab1[2],$tab1[3],$tab1[4],$tab1[5],$tab1[6],$tab1[7]);
                    //tab[0] = id_v tab[1] id_c tab[2] marque tab[3] modele tab[4]=couleur tab[5] nb place dispo tab[6]=annee

                   // print_r($tab1);
                    listTrajet($tab1);
                }
                else{
                    
                     if($_POST['ville_dep']==$_POST['ville_arriv']){
                        js("alert('La ville de départ et la ville d\'arrivée doivent être différentes')");
                        js("document.location.href = 'SelectTrajet.php'");
                    }
                    else{
                        $date_dep ='';
                        if(!empty($_POST['date_dep'])){
                            $date_dep =" and trajet.date_dep = '".$_POST['date_dep']."'";
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
                                        ville1.nom = '".$_POST['ville_dep']."' and
                                        ville2.nom = '".$_POST['ville_arriv']."'" 
                                        .$date_dep."
                                    "
                            ;
                            
                              $resultat2= mysqli_query($db, $select2);
                            if(!$resultat2) echo (mysqli_error($db));

                            $tab2 = array();

                            while($row = mysqli_fetch_assoc($resultat2)){
                              $tab2[]=$row;  
                            }
                            if(empty($tab2)){
                               js("alert('Trajet non trouv\é')");
                               js("document.location.href = 'SelectTrajet.php'");
                            }
                            
                            listTrajet($tab2);
                    }
                }
            ?>
             
         </div><!-- #contenu -->
    </div><!-- #centre -->
                
    <div id="pied">
		<p id="copyright">
			Mise en page &copy; 2015
			Chihoon Lee, Thibault Neulat
		</p>
	</div><!-- #pied -->
</div><!--#global-->
</body>
</html>