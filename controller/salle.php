<?php

include_once($root['view']['password']);
include_once($root['model']['salle']);
include_once($root['model']['lieu']);

if (isset($_GET['action']))
{
	switch ($_GET['action'])
	{
		case "addSalle" :
			if (!isset($_POST['name']) || empty($_POST['name']))
				header('location: ?href=salle&err=name_empty');
			else if (!isset($_POST['lieu']))
				header('location: ?href=salle&err=lieu_empty');
			else
			{
				insertsalle($_POST['lieu'], $_POST['name']);
				header('location: ?href=salle');
			}
			break;
		case "suppr":
			if (isset($_GET['data']))
				deletesalle($_GET['data']);
			header('location: ?href=salle');
			break;
	}
}
else if (isset($_GET['err']))
{
	switch ($_GET['err'])
	{
		case "name_empty":
			echo getMessageError('Il semblerai que le champs "Nom du salle" soit vide !');
			break;
	}
}

include_once($root['view']['salle']);

function getMessageError($phrase)
{
        return '<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Erreur!</strong>'.$phrase.'</div>';
}


?>
