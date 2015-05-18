<?php session_start(); ?>
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
                    <?php echo ("Bonjour, $login"); ?>
                </p>    
                <div id="centre">   
                    <div id="navigation">
                        <?php verifadmin($login); ?>
                    </div><!-- #navigation -->
                    <div id="contenu">

                        <?php
                        $i = -1;
                        do {
                            $i++;
                            //echo($i." ".isset($_POST['select'.$i]). "<p/>");
                            if (isset($_POST['select' . $i])) {
                                //echo "c'est bon: ".  $_POST['id_t'.$i]. "<p/>";
                                $id_t = $_POST['id_t' . $i]; //numero de trajet choisi par utilisateur
                            }
                        } while (!isset($_POST["select" . $i]));
                        include('connect.php');
                        //verification si l'utilisateur participe son propre trajet
                        $select1 = "select login
                        from compte
                        where id_c in   (   select id_conducteur
                                            from trajet
                                            where id_t = " . $id_t . "
                                        )
                        "
                        ;
                        $resultat1 = mysqli_query($db, $select1);
                        $tab1 = mysqli_fetch_array($resultat1);

                        if ($tab1[0] == $login) {
                            js("alert('Vous ne pouvez pas choisir le trajet effectu\é vous-même')");
                            js("document.location.href = 'SelectTrajet.php'");
                        } else {
                            //Recuperer toutes les info sur le trajet choisi
                            $select2 = "select  ville1.nom as Ville_Depart,
                                    ville2.nom as Ville_Arrivee,
                                    compte.nom, 
                                    compte.prenom, 
                                    trajet.date_dep, 
                                    trajet.heure_dep, 
                                    trajet.prix,
                                    vehicule.marque,
                                    vehicule.modele,
                                    trajet.nb_place_dispo
                                    
                            from compte, vehicule, trajet
                            join ville ville1 on trajet.ville_dep = ville1.id_ville
                            join ville ville2 on trajet.ville_arriv = ville2.id_ville
                            where   trajet.id_conducteur = compte.id_c and 
                                    vehicule.id_c = compte.id_c and
                                    trajet.id_t = " . $id_t . "
                          "
                            ;

                            $resultat2 = mysqli_query($db, $select2);
                            $tab2 = mysqli_fetch_array($resultat2);
                            /*
                              echo "  Conducteur: ".$tab2[3]." ".$tab2[2]."<br/>
                              Date de départ: ".$tab2[4]." à ".$tab2[5]."h<br/>
                              Vehicule : ".$tab2[7]." ".$tab2[8]."<br/>
                              Prix : ".$tab2[6]." euros<p/>";
                             */
                            $_SESSION['nom'] = $tab2[2];
                            $_SESSION['prenom'] = $tab2[3];
                            $_SESSION['date'] = $tab2[4];
                            $_SESSION['heure'] = $tab2[5];
                            $_SESSION['prix'] = $tab2[6];
                            $_SESSION['marque'] = $tab2[7];
                            $_SESSION['modele'] = $tab2[8];
                            $_SESSION['place'] = $tab2[9];
                            $_SESSION['id_t'] = $id_t;


                            header('location:SelectTrajet3.php');
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