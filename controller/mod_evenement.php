<?php

include_once($root['view']['password']);
include_once($root['model']['evenement']);
include_once($root['model']['lieu']);
include_once($root['model']['salle']);
if (isset($_GET["action"]))
{
	switch ($_GET["action"])
	{
		case "modif" :
			if (isset($_GET["data"]) && verifValue())
			{
				$zt = isset($_POST['0-3']);
				$ts = isset($_POST['3-6']);
				$sd = isset($_POST['6-12']);
				$dp = isset($_POST['12+']);
				$ad = isset($_POST['adulte']);
				modifEvenement($_GET['data'],
							   $_POST['name_event'],
						   	   $_POST['description'],
						   	   $_POST['lieu'],
						   	   $_POST['salle'],
						   	   $_POST['nb_place'],
						   	   $_POST['date'],
						   	   $_POST['hour'],
						   	   $_POST['deve_month'],
						   	   $_POST['deve_day'],
   								$zt,
								$ts,
								$sd,
								$dp,
								$ad);
				header('location: ?href=mod_evenement');
			}
			break;			
		case "suppr":
			if (isset($_GET["data"]))
			{
				supprEvent($_GET["data"]);
				header('location: ?href=mod_evenement');
			}
	}
}
else if (isset($_GET['err']))
	switch ($_GET['err'])
	{
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
		case "date_empty":
			echo getMessageError('Il semblerai que le champs "Date" soit vide !');
			break;
		case "hour_empty":
			echo getMessageError('Il semblerai que le champs "Heure" soit vide !');
			break;
		case "deve_month_empty":
			echo getMessageError('Il semblerai que le champs "Nombre de mois avant le deverouillage" soit vide !');
			break;
		case "dev_day_empty":
			echo getMessageError('Il semblerai que le champs "Nombre de jours avant le deverouillage" soit vide !');
			break;
}

function getMessageError($phrase)
{
	return '<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Erreur!</strong>'.$phrase.'</div>';
}

function verifValue()
{
	if (!isset($_POST['name_event']) || empty($_POST['name_event']))
		header('location: ?href=mod_evenement&err=name_event_empty');
	else if (!isset($_POST['description']) || empty($_POST['description']))
		header('location: ?href=mod_evenement&err=description_empty');
	else if (!isset($_POST['lieu']))
		header('location: ?href=mod_evenement&err=lieu_empty');
	else if (!isset($_POST['salle']))
		header('location: ?href=mod_evenement&err=salle_empty');
	else if (!isset($_POST['nb_place']))
		header('location: ?href=mod_evenement&err=nb_place_empty');
	else if (!isset($_POST['date']) || empty($_POST['date']))
		header('location: ?href=mod_evenement&err=date_empty');
	else if (!isset($_POST['hour']) || empty($_POST['hour']))
		header('location: ?href=mod_evenement&err=hour_empty');
	else if (!isset($_POST['deve_month']))
		header('location: ?href=mod_evenement&err=deve_month_empty');
	else if (!isset($_POST['deve_day']) || empty($_POST['deve_day']))
		header('location: ?href=mod_evenement&err=deve_day_empty');
	else
		return true;
}

include_once($root['view']['mod_evenement']);
?>