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
                        include('connect.php');
                        //Verifier si utilisateur a deja enregistrer son vehicule
                        $exist = "  select * 
                from vehicule
                where id_c in (select id_c
                            from compte 
                            where login = '" . $login . "')
            "
                        ;

                        $resultat = mysqli_query($db, $exist);
                        if (!$resultat)
                            echo (mysqli_error($db));
                        $tab = mysqli_fetch_array($resultat);
                        //tab[0] = id_v tab[1] id_v tab[2] marque tab[3] modele tab[4]=couleur tab[5] nb place dispo tab[6]=annee
                        if (empty($tab)) { //utilisateur a jamais enregistrer son vehicule
                            $id = "select id_c from compte where login = '" . $login . "'";
                            $resultat_id = mysqli_query($db, $id);
                            $tab2 = mysqli_fetch_array($resultat_id); //pck on a besoin de "id"

                            echo "<fieldset style='margin: auto'>
            <Legend>Information sur véhicule</legend>
            <form method='post' action='infovehicule.php'>
            <label>Marque</label>
            <input type='text' name='marque'/>
            <p/>
            <label>Modèle</label>
            <input type='text' name='modele'/>
            <p/>
            <label>Couleur</label>
            <input type='text' name='couleur'/>
            <p/>
            <label>Nombre de places (sans comptant le conducteur)</label>
            <select name='nb_place'>";
                            listNbPlace(0);
                            echo "<p/>
            <label>Année de remise</label>";
                            listannee(1980, 35, 0);
                            echo "
            <input type='submit' name = 'submit' value='Valider'/>
            <p/>
            </form>
            </fieldset>";
                        } else { //l'utilisateur a deja enregistrer vehicule
                            echo "<fieldset style='margin: auto'>
            <Legend>Information sur véhicule</legend>
            <form method='post' action='infovehicule.php'>
            <label>Marque</label>
            <input type='text' value = '" . $tab[2] . "' name='marque'/>
            <p/>
            <label>Modèle</label>
            <input type='text' value = '" . $tab[3] . "' name='modele'/>
            <p/>
            <label>Couleur</label>
            <input type='text' value = '" . $tab[4] . "' name='couleur'/>
            <p/>
            <label>Nombre de places (sans comptant le conducteur)</label>
            <select name='nb_place'>";
                            listNbPlace($tab[5]);
                            echo "<p/>
            <label>Année de remise</label>";
                            listannee(1980, 35, $tab[6]);
                            echo "
            <input type='submit' name = 'submit' value='Valider'/>
            <p/>
            </form>
            </fieldset>";
                        }



                        if (isset($_POST['submit']) && $_POST['submit'] == 'Valider') {

                            if ((isset($_POST['marque']) && !empty($_POST['marque'])) && (isset($_POST['modele']) && !empty($_POST['modele'])) && (isset($_POST['couleur']) &&
                                    !empty($_POST['couleur']))) {

                                $marque = $_POST['marque'];
                                $modele = $_POST['modele'];
                                $couleur = $_POST['couleur'];
                                $nb_place = $_POST['nb_place'];
                                $annee = $_POST['annee'];
                                if (empty($tab)) { //si l'utilisateur n'a jamais enregistrer son vehicule, on insere ses informations
                                    $insert = "Insert into vehicule
                                Values 
                                (  
                                    '',
                                    '" . $tab2[0] . "', 
                                    '" . $marque . "',
                                    '" . $modele . "',
                                    '" . $couleur . "',
                                    '" . $nb_place . "',
                                    '" . $annee . "'
                                )
                                 "
                                    ;
                                    $resultat_insert = mysqli_query($db, $insert);
                                    if ($resultat_insert) {
                                        js("alert('Insert successful')");
                                        js("document.location.href = 'accueil.php'");
                                    } else
                                        echo (mysqli_error($db));
                                }
                                else { //sinon on fait mise a jour les modifications sur le vehicule
                                    $update = "   Update vehicule
                                Set id_c = '" . $tab[1] . "', 
                                    marque = '" . $marque . "',
                                    modele = '" . $modele . "',
                                    couleur = '" . $couleur . "',
                                    nb_place = '" . $nb_place . "',
                                    annee = '" . $annee . "'
                                where id_c = " . $tab[1] . "
                            
                             "
                                    ;
                                    $resultat_update = mysqli_query($db, $update);
                                    if ($resultat_update) {
                                        js("alert('Update successful')");
                                        js("document.location.href = 'accueil.php'");
                                    } else
                                        echo (mysqli_error($db));
                                }
                            }
                            else {
                                js("alert('Un de vos champ est vide')");
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
