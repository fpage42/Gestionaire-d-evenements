<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Gestionaire d'évènement</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-switch.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      [class*="col"] { margin-bottom: 20px; }
      img { width: 100%; }
      body { margin-top: 10px;}
    </style>
  </head>
<?php
include_once("root.php");
include_once("include/mysql.php");
ini_set('display_errors','on');
error_reporting(E_ALL);
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
session_start();
if (isset($_SESSION['pass']) && $_SESSION['pass'] == $config['pass'])
{
	echo "<a style='margin-left:10px;' href=?href=resetPass>Changer le mot de passe</a>";
	echo "<a style='float:right; margin-right:10px;' href=?href=logout>Déconnexion</a>";
}
	$nav = "include/nav.php";
	  if (isset($_GET['password']))
	  {
		  if ($_GET['password'] == "ok")
			  echo '<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Vous êtes maintenant connecté</div>';
			else if ($_GET['password'] == "dec")
				echo '<div class="alert alert-info alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Erreur!</strong>Vous êtes maintenant déconnecté</div>';
			else
				echo '<div class="alert alert-danger alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Erreur!</strong>Votre mot de passe semble incorrect</div>';
					  }
	  if (isset($_GET['href']) && !empty($_GET['href']))
	  {
		  if (($root['controller'][$_GET['href']]) != "")
			  $path = $root['controller'][$_GET['href']];
	  }
	  else
		  $path = $root['controller']['index'];
?>


  <body style="margin-top: 20px">
    <div class="container">
	  <?php

include($nav);
include($path);
?>
      </div>


    <script src="js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js "></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootstrap-switch.js"></script>
    <script src="bootstrap/js/highlight.js"></script>
    <script src="bootstrap/js/main.js"></script>

  </body>
</html>
