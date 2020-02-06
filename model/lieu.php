<?php

function insertLieu($name, $tel)
{
	global $db;
	global $database;

	$req = $db->prepare('INSERT INTO '.$database.'.`lieu` (`nom`, `telephone`) VALUE (:name, :tel)');

	$req->execute(array(':name' => $name,
						':tel' => $tel));
}

function getAllLieu()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`lieu`');
	$req->execute();
	$res = $req->fetchAll();
	array_push($res, array('id' => 0, 'nom' => 'Aucun', 'telephone' => '01 41 94 65 50'));

	return $res;
}

function getLieuById($id)
{
	if ($id == 0)
		return array('id' => 0, 'nom' => 'Aucun', 'telephone' => '01 41 94 65 50');
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`lieu` WHERE id=:id');
	$req->execute(array(':id' => $id));
	$res = $req->fetchAll();

	return $res[0];
}

function deleteLieu($id)
{
	global $db;
	global $database;

	$req = $db->prepare('DELETE FROM '.$database.'.`lieu` WHERE id=:id');
	$req->execute(array(':id' => $id));
}
?>
