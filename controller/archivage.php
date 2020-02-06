<?php

include_once($root['model']['evenement']);
include_once($root['model']['inscrit']);
include_once($root['model']['archive_evenement']);
include_once($root['model']['archive_inscrit']);
include_once($root['model']['salle']);
include_once($root['model']['lieu']);
include_once($root['model']['type']);

if (isset($_GET['action']))
{
	switch ($_GET['action'])
	{
		case "presence" :
			if (isset($_POST['personneSupple']) && isset($_GET['data']) && isset($_GET['nbCheckBox']))
			{
				$idArchive = archiveEvent(0, $_GET['data'], $_POST['personneSupple']);
				$i = -1;
				while (++$i < $_GET['nbCheckBox'])
					addArchiveInscrit($_GET['data'], $idArchive, $i, isset($_POST['box_'.$i]));
				supprEvent($_GET['data']);
			}
			break;
		case "nb_personne" :
			$idArchive = archiveEvent(1, $_GET['data'], $_POST['personnePres']);
			archiveAllInscrit($_GET['data'], $idArchive);
			supprEvent($_GET['data']);
			break;
		case "addInscrit" :
			if (isset($_GET['data']) && verifChamps())
			{
				addInscrit($_GET['data'], ucfirst(strtolower($_POST['nom'])), ucfirst(strtolower($_POST['prenom'])), $_POST['email'], $_POST['telephone'], $_POST['age'], $_POST['mois']);
			}
	}
	header('location: ?href=archivage');
}
else
	include_once($root['view']['archivage']);

function verifChamps()
{
	if (!isset($_POST['nom']))
		header("location: ?href=index&err=nom_empty");
	else if (!isset($_POST['prenom']))
		header("?href=index&err=prenom_empty");
	return true;
}
?>