<?php

function insertSalle($id_lieu, $name)
{
	global $db;
	global $database;

	$req = $db->prepare('INSERT INTO '.$database.'.`salle` (`id_lieu`, `nom`) VALUE (:id_lieu, :name)');

	$req->execute(array(':id_lieu' => $id_lieu,
						':name' => $name));
}

function getAllSalle()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`salle`');
	$req->execute();
	$res = $req->fetchAll();
	array_push($res, array('id' => 0, 'nom' => 'Aucun', 'id_lieu' => null));

	return $res;
}

function getSalleById($id)
{
	if ($id == 0)
		return array('id' => 0, 'nom' => 'Autre');
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`salle` WHERE id=:id');
	$req->execute(array(':id' => $id));
	$res = $req->fetchAll();

	return $res[0];
}

function getSalleByLieu($id_lieu)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`salle` WHERE id_lieu=:id_lieu');
	$req->execute(array(':id_lieu' => $id_lieu));
	$res = $req->fetchAll();

	return $res;
}
function getSalleByNom($nom)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`salle` WHERE nom=:nom');
	$req->execute(array(':nom' => $nom));
	$res = $req->fetchAll();

	return $res[0];
}

function deleteSalle($id)
{
	global $db;
	global $database;

	$req = $db->prepare('DELETE FROM '.$database.'.`salle` WHERE id=:id');
	$req->execute(array(':id' => $id));
}
?>
