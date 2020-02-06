<?php

include_once($root['view']['password']);
include_once($root['model']['lieu']);

if (isset($_GET['action']))
{
	switch ($_GET['action'])
	{
		case "addlieu" :
			if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['tel']) && !empty($_POST['tel']))
			{
				insertLieu($_POST['name'], $_POST['tel']);
				header('location: ?href=lieu');
			}
			else
				header('location: ?href=lieu&err=name_empty');
		case "suppr":
			if (isset($_GET['data']))
			{
				deleteLieu($_GET['data']);
			}
	}
}
else if (isset($_GET['err']))
{
	switch ($_GET['err'])
	{
		case "name_empty":
			echo getMessageError('Il semblerai que le champs "Nom du lieu" soit vide !');
			break;
	}
}

include_once($root['view']['lieu']);

function getMessageError($phrase)
{
        return '<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Erreur!</strong>'.$phrase.'</div>';
}


?>
