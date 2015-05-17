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
                
                //Verification d'existence de ses trajets
                $select1 = "select  ville1.nom as Ville_Depart,
                                    ville2.nom as Ville_Arrivee,
                                    trajet.date_dep, 
                                    trajet.heure_dep, 
                                    trajet.nb_place_dispo, 
                                    trajet.prix,
                                    trajet.id_t
                                    
                                from compte, vehicule, trajet
                                join ville ville1 on trajet.ville_dep = ville1.id_ville
                                join ville ville2 on trajet.ville_arriv = ville2.id_ville
                               
                                where   compte.login = '".$login."' and
                                        trajet.id_conducteur = compte.id_c and
                                        vehicule.id_c = compte.id_c and
                                        trajet.isEffectue = 0 
                            "
                ; 
                
                $resultat1= mysqli_query($db, $select1);
                    if(!$resultat1) echo (mysqli_error($db));

                    $tab1 = array();

                    while($row = mysqli_fetch_assoc($resultat1)){
                      $tab1[]=$row;  
                    }
               
                    PreparerTrajet($tab1);
                
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