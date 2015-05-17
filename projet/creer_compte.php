<?php 
    session_start();
    include('fonctions.php')
    ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Covoiturage</title></head>
    <link rel="stylesheet" type="text/css" href="base.css" media="all" />
    <body>
        
<?php
    //Verification si l'utlisateur est deja identifié
    if(!empty($_SESSION['login'])){
        header('location:accueil.php');
    }

?>
        
        <h1 style="text-align: center;margin-top: 0px;">Créer votre compte</h1>
        <fieldset style="margin: auto;">
        <?php action("post","creer_compte.php");?>
            
            <label>Nom</label>
            <input type="text" name="nom"/>
            <p/>
            <label>Prenom</label>
            <input type="text" name="prenom"/>
            <p/>
            <label>Date de naissance(sous forme jjmmaa ex. 7 juin 1994 : 070694)</label>
            <input type="text" name="datenaissance" maxlength="6" minlength="6"/>
            <p/>
            <label>Login</label>
            <input type="text" name="login"/>
            <p/>
            <label>Mots de passe</label>
            <input type="password" name="mdp" minlength="4" maxlength="20"/>
            <p/>
            <label>Confirmation mdp</label>
            <input type="password" name="confirm_mdp"/>
            <p/>
            <label>Photo</label>
            <input type="file" name="photo1" id="photo" /><p/>
            <input type="submit" name= "submit" value="Valider"/>
            <input type="reset" value="Effacer"/>
            
            <p/>
            </form>
            </fieldset>    
            <?php
        //verification de champs vides
        if (isset($_POST['submit']) && $_POST['submit'] == 'Valider'){
             if((isset($_POST['nom']) && !empty($_POST['nom'])) && (isset($_POST['prenom']) && !empty($_POST['prenom'])) && (isset($_POST['datenaissance']) && 
                !empty($_POST['datenaissance'])) && (isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['mdp']) && !empty($_POST['mdp'])) && 
                (isset($_POST['confirm_mdp']) && !empty($_POST['confirm_mdp']))){
            //verification de mots de passe
                if($_POST['mdp']!=$_POST['confirm_mdp']){
                    echo js("alert('Les deux mots de passes sont différents')");
                }
                else{
                    include('connect.php');
                    $nom=$_POST['nom'];
                    $prenom=$_POST['prenom'];
                    $datenaissance=$_POST['datenaissance'];
                    $login=$_POST['login'];
                    $mdp=$_POST['mdp'];

                    $exist_login = "select distinct login
                                    from compte
                                    where login = '". $login ."'
                                    "
                    ;

                    $resultat_login = mysqli_query($db, $exist_login);
                    //echo ("<p/>Login : $login<br/>");
                    $logindansbd=  mysqli_fetch_row($resultat_login)[0];
                    //echo "Login selected dans bd : " .$logindansbd . "<br/>";
                     if($logindansbd==$login){
                        echo js("alert('Ce login existe déjà')");
                    }
                    else{                
                        $insert =  
                                "Insert into compte
                                Values 
                                (  
                                    '',
                                    '".$nom."',
                                    '".$prenom."',
                                    '".$datenaissance."',
                                    '".$login."',
                                    '".$mdp."',
                                    '0',
                                    ''
                                )
                                 "             
                        ;
                        $resultat_insert = mysqli_query($db,$insert);

                        if($resultat_insert){
                            js("alert('Compte créé')");
                            js("document.location.href = 'Login.php'");
                        }
                        else
                        echo (mysqli_error($db));
                    }
                }
            }
            else js("alert('Au moins un champ est vide')");
        }
?>
            
</body>
</html>