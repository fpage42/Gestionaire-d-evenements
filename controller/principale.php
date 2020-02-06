<?php

include_once($root['model']['evenement']);
include_once($root['model']['inscrit']);
include_once($root['model']['lieu']);
include_once($root['model']['salle']);
include_once($root['model']['type']);

if (isset($_GET['action']))
{
	switch ($_GET['action'])
	{
		case 'inscrit':
			if (isset($_GET['data']) && verifChamps() && verifPlace())
			{
				addInscrit($_GET['data'], ucfirst(strtolower($_POST['nom'])), ucfirst(strtolower($_POST['prenom'])), $_POST['email'], $_POST['telephone'], $_POST['age'], $_POST['mois'], $_POST['comment']);
				header("location: ?href=index&event=".$_GET['data']);
			}
		case 'suppr_user' :
			if (isset($_GET['user']))
			{
				remInscrit($_GET['user']);
				header("location: ?href=index&event=".$_GET['data']);
			}
			case 'modif':
			if (isset($_GET['data']) && isset($_GET['user']) && verifChamps())
			{
				modifInscrit($_GET['user'], ucfirst(strtolower($_POST['nom'])), ucfirst(strtolower($_POST['prenom'])), $_POST['email'], $_POST['telephone'], $_POST['age'], $_POST['mois'], $_POST['comment']);
				header("location: ?href=index&event=".$_GET['data']);
			}
	}
}

include_once($root['view']['index']);

function verifPlace()
{
	if (getNbPlace($_GET['data']) < count(getInscrit($_GET['data'])))
	{
		header("location: ?href=index&err=nom_empty&err=place");
		exit();
	}
	return true;
}

function verifChamps()
{
	if (!isset($_POST['nom']) || $_POST['nom'] == "")
	{
		header("location: ?href=index&err=nom_empty&event=".$_GET['data']);
		exit();
	}
	else if (!isset($_POST['prenom']) || $_POST['prenom'] == "")
	{
		header("?href=index&err=prenom_empty&event=".$_GET['data']);
		exit();
	}
	return true;
}
?>