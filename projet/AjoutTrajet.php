<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Covoiturage</title></head>
    <link rel="stylesheet" type="text/css" href="base.css" media="all" />
    <body>
        
<?php
session_start();
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
                //Verifier si utilisateur a deja enregistrer son vehicule
                $select1 = "  select * 
                            from vehicule
                            where id_c in (select id_c
                                        from compte 
                                        where login = '".$login."')
                        "
                ;

                $resultat= mysqli_query($db, $select1);
                if(!$resultat) echo (mysqli_error($db));
                $tab = mysqli_fetch_array($resultat);
                //tab[0] = id_v tab[1] id_c tab[2] marque tab[3] modele tab[4]=couleur tab[5] nb place dispo tab[6]=annee
                
               
                
         
                if(empty($tab)){ //utilisateur a jamais enregistrer son vehicule
                    js("alert('Veuillez d abord enregistrer votre vehicule')");
                    js("document.location.href = 'infovehicule.php'");
                }
                else{
                    
                            //Liste ville
                       $select2 =  " select nom
                                     from ville;
                                   "
                       ;
                       $result_select2= mysqli_query($db, $select2);
                       if(!$result_select2) echo (mysqli_error($db));
                   
                       while($row = mysqli_fetch_array($result_select2)){
                           $tab_ville[] = $row['nom'];
                       }
                      /* while ($row = mysqli_fetch_assoc($result_select2) ){ 
                           $key = $row['nom']; 
                           $tab_ville[$key] = $row['dept']; 
                       }*/  // tableau associatif

                    //debut formulaire
                    echo "  <fieldset style='margin: auto'>
                                <Legend>Ajouter un trajet</legend>
                                <form method='post' action='AjoutTrajet.php'>
                                <label>Ville de départ</label>
                                <select name='ville_dep'>";
                                listVille($tab_ville);
                            echo "
                                <label>Ville d'arrivé</label>
                                <select name='ville_arriv'>";
                                listVille($tab_ville);
                            echo "
                                <label>Date départ(sous forme jjmmaa ex. 7 juin 1994 : 070694)</label>
                                <input type='text' name='date_dep' maxlength='6' minlength='6'/>";
                                listheure();    
                        echo "  <label>Nombre de places disponibles</label>
                                <select name='nb_place_dispo'>";
                                listNbPlace($tab[5]);
                        echo "  <label>Prix</label>
                                <input type='text' name='prix'/> euros
                                <p/>
                                <input type='submit' name = 'submit' value='Valider'/>
                                <p/>
                                </form>
                            </fieldset>";
                        //fin de formulaire
                           
                        
                        
                        if(isset($_POST['submit']) && $_POST['submit'] == 'Valider'){
                            if((isset($_POST['ville_dep']) && !empty($_POST['ville_dep'])) && (isset($_POST['ville_arriv']) && !empty($_POST['ville_arriv'])) && (isset($_POST['date_dep']) && 
                                !empty($_POST['date_dep'])) && (isset($_POST['heure_dep']) && !empty($_POST['heure_dep'])) && (isset($_POST['nb_place_dispo']) && !empty($_POST['nb_place_dispo'])) 
                                    && (isset($_POST['prix']) && !empty($_POST['prix']))){
                                $ville_dep = $_POST['ville_dep'];
                                $ville_arriv = $_POST['ville_arriv'];
                                $date_dep = $_POST['date_dep'];
                                $heure_dep = $_POST['heure_dep'];
                                $nb_place_dispo = $_POST['nb_place_dispo'];
                                $prix = $_POST['prix'];
                                
                                if($ville_dep==$ville_arriv){
                                    js("alert('La ville de départ et la ville d\'arrivée doivent être différentes')");
                                    js("document.location.href = 'AjoutTrajet.php'");
                                }
                                else{
                                
                                    //select les deux id_villes
                                    $select3 =  "
                                                            select id_ville
                                                            from ville
                                                            where nom='".$ville_dep."'
                                                        "
                                    ;

                                    $select4 =  "
                                                            select id_ville
                                                            from ville
                                                            where nom='".$ville_arriv."'
                                                        "
                                    ;

                                    $result_select3= mysqli_query($db, $select3);
                                    if(!$result_select3) echo (mysqli_error($db));

                                    $result_select4= mysqli_query($db, $select4);
                                    if(!$result_select4) echo (mysqli_error($db));

                                    $ville_dep = mysqli_fetch_array($result_select3);
                                    $ville_arriv = mysqli_fetch_array($result_select4);



                                    $insert =  
                                            "   Insert into trajet
                                                Values 
                                                (  
                                                    '',
                                                    '".$tab[1]."',
                                                    '".$ville_dep[0]."',
                                                    '".$ville_arriv[0]."',
                                                    '".$date_dep."',
                                                    '".$heure_dep."',
                                                    '".$nb_place_dispo."',
                                                    '".$prix."',
                                                    ''
                                                )
                                            "             
                                    ;
                                    $result_insert= mysqli_query($db, $insert);
                                    if(!$result_insert) echo (mysqli_error($db));
                                    else{
                                        js("alert('Insert successful')");
                                        js("document.location.href = 'accueil.php'");
                                    }
                                }
                            }
                            else{
                                js("alert('Un de vos champ est vide')");
                            }
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