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
                        $mdp = $_SESSION['mdp'];
                        include('connect.php');
                        $exist = "  select distinct nom,prenom,datenaissance
                from compte
                where login = '" . $login . "'
             "
                        ;
                        $resultat = mysqli_query($db, $exist);
                        $tab = mysqli_fetch_array($resultat);  //tab[0] = nom , tab[1] = prenom, tab[2] = datenaissance
                        $nom = $tab[0];
                        $prenom = $tab[1];
                        $datenaissance = $tab[2];
                        ?>  
                        <fieldset style="margin: auto;">
                            <legend>Caractéristique du compte</legend>
                            <?php
                            action("post", "Modification.php");

                            echo "<label>Nom</label>
            <input type='text' value='$nom' name='nom'/>
            <p/>
            <label>Prenom</label>
            <input type='text' value='$prenom' name='prenom'/>
            <p/>
            <label>Date de naissance(sous forme jjmmaa ex. 7 juin 1994 : 070694)</label>
            <input type='text' value='$datenaissance' name='datenaissance' maxlength='6' minlength='6'/>
            <p/>
            <label>Login</label>
            <input type='text' name='login' value='$login' disabled='disabled'/>
            <p/>
            <label>Mots de passe</label>
            <input type='password' name='mdp' minlength='4' maxlength='20'/>
            <p/>
            <label>Confirmation mdp</label>
            <input type='password' name='confirm_mdp'/>
            <p/>
            <label>Photo</label>
            <input type='file' name='photo1' id='photo' /><p/>
            <input type='submit' name= 'submit' value='Valider'/>
            <input type='reset' value='Effacer'/>
            <p/>
        </form>
        </fieldset>";


//verification de champs vides
                            if (isset($_POST['submit']) && $_POST['submit'] == 'Valider') {
                                if ((isset($_POST['nom']) && !empty($_POST['nom'])) && (isset($_POST['prenom']) && !empty($_POST['prenom'])) && (isset($_POST['datenaissance']) &&
                                        !empty($_POST['datenaissance']))) {
                                    $newnom = $_POST['nom'];
                                    $newprenom = $_POST['prenom'];
                                    $newdate = $_POST['datenaissance'];
                                    //verification de mots de passe
                                    if ((isset($_POST['mdp']) && !empty($_POST['mdp']))) {
                                        if ($_POST['mdp'] != $_POST['confirm_mdp']) {
                                            js("alert('Les deux mots de passes sont différents')");
                                        } else {
                                            $newmdp = $_POST['mdp'];
                                            $update = "update compte
                        set nom             = '" . $newnom . "' ,
                            prenom          = '" . $newprenom . "' ,
                            datenaissance = '" . $newdate . "' ,
                            mdp             = '" . $newmdp . "'
                        where login = '" . $login . "'
                            "
                                            ;
                                            $resultat_update = mysqli_query($db, $update);

                                            if ($resultat_update) {
                                                js("alert('Update successful')");
                                                js("document.location.href = 'accueil.php'");
                                            } else
                                                echo (mysqli_error($db));

                                            // header('Location: '.$_SERVER['REQUEST_URI']);
                                        }
                                    }

                                    else {
                                        $update = "Update compte
                            set nom         = '" . $newnom . "' ,
                            prenom          = '" . $newprenom . "' ,
                            datenaissance = '" . $newdate . "'
                            where login = '" . $login . "'
                           "
                                        ;

                                        $resultat_update = mysqli_query($db, $update);
                                        if ($resultat_update) {
                                            js("alert('Update successful')");
                                            js("document.location.href = 'accueil.php'");
                                        } else
                                            echo (mysqli_error($db));

                                        //header('Location: '.$_SERVER['REQUEST_URI']);
                                    }
                                } else
                                    js("alert('Un de vos champ est vide')");
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