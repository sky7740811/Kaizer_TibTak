<?php session_start();?>
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
			<?php verifadmin($login);?>
        </div><!-- #navigation -->
         <div id="contenu">
            <p>Ceci est la page d'accueil Ceci est la page d'accueil Ceci est la page d'accueil Ceci est la page d'accueil Ceci est la page d'accueil Ceci est la page d'accueil Ceci est la page d'accueil Ceci est la page d'accueil</p>
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