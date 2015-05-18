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
                        //verifier si utilisateur a deja reserver ce trajet

                        include('connect.php');

                        $select = " select id_c
                        from compte
                        where login = '" . $login . "'
                        "
                        ;

                        $result_select = mysqli_query($db, $select);
                        $id_c = mysqli_fetch_array($result_select);
                        /*
                          $select2 = " select id_passager
                          from participe
                          where id_passager = '".$id_c[0]."' and
                          id_t in (select id_t
                          from trajet
                          where id_t = '".$_SESSION['id_t']."'
                          )
                          "
                          ;
                          $result_select2 = mysqli_query($db, $select2);
                          $exist = mysqli_fetch_array($result_select2);
                          if(!empty($exist)){
                          js("alert('Vous avez deja reserver ce trajet!')");
                          js("document.location.href = 'SelectTrajet.php'");
                          } */

                        echo "  Conducteur: " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . "<br/>
                            Date de départ: " . $_SESSION['date'] . " à " . $_SESSION['heure'] . "h<br/>
                            Vehicule : " . $_SESSION['marque'] . " " . $_SESSION['modele'] . "<br/>
                            Prix : " . $_SESSION['prix'] . " euros<p/>";

                        echo "<form method='post' action='SelectTrajet3.php'>";
                        echo "<label>Je réserve</label><br/>";
                        echo "<select name='reserve'>";
                        for ($i = 1; $i <= $_SESSION['place']; $i++) {
                            if ($i == 1) {
                                echo "<option>" . $i . " place</option>";
                            } else
                                echo "<option>" . $i . " places</option>";
                        }
                        echo "</select><p/>";
                        echo "<input type='submit' name='submit' value='Valider'/></form><p/>";

                        if (isset($_POST['submit'])) {
                            if (isset($_POST['reserve'])) {

                                $insert = "insert into participe values(
                                    '" . $_SESSION['id_t'] . "',
                                    '" . $id_c[0] . "'
                                    )                        
                                    "
                                ;


                                for ($j = 0; $j < $_POST['reserve']; $j++) {
                                    $resultat = mysqli_query($db, $insert);
                                }
                                //Additionner la somme d'argent gagner par conducteur
                                /*   $prix = ($_POST['reserve'] * $_SESSION['prix']);
                                  $update0 = "update compte set
                                  argent = argent + ".$prix."
                                  where id_c in (select id_conducteur
                                  from trajet
                                  where id_t = '".$_SESSION['id_t']."'
                                  )
                                  "
                                  ;
                                  $resultat_update0 = mysqli_query($db, $update0);
                                 */
                                $nbre_place_dispo = $_SESSION['place'] - $_POST['reserve'];

                                $update = " UPDATE trajet SET
                                        nb_place_dispo = '" . $nbre_place_dispo . "'
                                        where id_t = '" . $_SESSION['id_t'] . "'
                                      "
                                ;
                                $resultat1 = mysqli_query($db, $update);
                                js("alert('Reservation Effectuee')");
                                js("document.location.href = 'accueil.php'");
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