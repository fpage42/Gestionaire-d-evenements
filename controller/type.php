<?php
ini_set('display_errors','on');
error_reporting(E_ALL);
	include_once($root['view']['password']);
	include_once($root['model']['type']);
	include_once($root['model']['lieu']);
	include_once($root['model']['salle']);
	if (isset($_GET['action']))
	{
		switch ($_GET['action'])
		{
			case "crea_type":
				if (verif_value())
				{
					$zt = isset($_POST['0-3']);
					$ts = isset($_POST['3-6']);
					$sd = isset($_POST['6-12']);
					$dp = isset($_POST['12+']);
					$ad = isset($_POST['adulte']);
					insertType($_POST['name_type'],
							   $_POST['name_event'],
							   $_POST['description'],
							   $_POST['lieu'],
							   $_POST['salle'],
							   $_POST['nb_place'],
							   $_POST['deve_month'],
							   $_POST['deve_day'],
							   $zt,
							   $ts,
							   $sd,
							   $dp,
							   $ad);
					header('location: ?href=type');
				}
				break;
			case "suppr":
				if (isset($_GET['data']))
					supprType($_GET['data']);
				header('location: ?href=type');
				break;
			case "modif":
				if (isset($_GET['data']))
				{
					if (verif_value())
					{
						$zt = isset($_POST['0-3']);
						$ts = isset($_POST['3-6']);
						$sd = isset($_POST['6-12']);
						$dp = isset($_POST['12+']);
						$ad = isset($_POST['adulte']);
						modifType($_GET['data'],
								  $_POST['name_type'],
								  $_POST['name_event'],
								  $_POST['description'],
								  $_POST['lieu'],
								  $_POST['salle'],
								  $_POST['nb_place'],
								  $_POST['deve_month'],
								  $_POST['deve_day'],
								  $zt,
								  $ts,
								  $sd,
								  $dp,
								  $ad);
						header('location: ?href=type');
					}
				}
				break;
		}
	}
	else if (isset($_GET['err']))
		switch ($_GET['err'])
		{
			case "name_type_empty":
				echo getMessageError('Il semblerai que le champs "Nom du type d\'evenement" soit vide !');
				break;
			case "name_event_empty":
				echo getMessageError('Il semblerai que le champs "Nom de l\'evenement" soit vide !');
				break;
			case "description_empty":
				echo getMessageError('Il semblerai que le champs "Desciption" soit vide !');
				break;
			case "lieu_empty":
				echo getMessageError('Il semblerai que le champs "Lieu" soit vide !');
				break;
			case "salle_empty":
				echo getMessageError('Il semblerai que le champs "Salle" soit vide !');
				break;
			case "nb_place_empty":
				echo getMessageError('Il semblerai que le champs "Nombre de place" soit vide !');
				break;
			case "deve_month_empty":
				echo getMessageError('Il semblerai que le champs "Nombre de mois avant le deverouillage" soit vide !');
				break;
			case "dev_day_empty":
				echo getMessageError('Il semblerai que le champs "Nombre de jours avant le deverouillage" soit vide !');
				break;
		}

	include($root['view']['type']);


	//verifie si les champs du formulaire sont remplis
	function getMessageError($phrase)
	{
		return '<div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Erreur!</strong>'.$phrase.'</div>';
	}
	function verif_value()
	{
		if (!isset($_POST['name_type']) || empty($_POST['name_type']))
			header('location: ?href=type&err=name_type_empty');
		else if (!isset($_POST['name_event']) || empty($_POST['name_event']))
			header('location: ?href=type&err=name_event_empty');
		else if (!isset($_POST['description']) || empty($_POST['description']))
			header('location: ?href=type&err=description_empty');
		else if (!isset($_POST['lieu']))
			header('location: ?href=type&err=lieu_empty');
		else if (!isset($_POST['salle']))
			header('location: ?href=type&err=salle_empty');
		else if (!isset($_POST['nb_place']))
			header('location: ?href=type&err=nb_place_empty');
		else if (!isset($_POST['deve_month']))
			header('location: ?href=type&err=deve_month_empty');
		else if (!isset($_POST['deve_day']) || empty($_POST['deve_day']))
			header('location: ?href=type&err=deve_day_empty');
		else
			return true;
	}
?>