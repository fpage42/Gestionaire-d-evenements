<?php

function insertType($name_type, $name_event, $description, $id_lieu, $id_salle, $place, $deve_month, $deve_day, $zt, $ts, $sd, $dp, $ad)
{
	global $db;
	global $database;

	$req = $db->prepare('INSERT INTO '.$database.'.`type` (`nom_type`, `nom_event`, `description`, `id_lieu`, `id_salle`, `nb_place`, `deve_month`, `deve_day`, `03`, `36`, `612`, `12`, `adulte`) VALUES (:nom_type, :nom_event, :description, :id_lieu, :id_salle, :place, :deve_month, :deve_day, :03, :36, :612, :12, :adulte)');
	$req->execute(array(
	':nom_type' => $name_type,
	':nom_event' => $name_event,
	':description' => $description,
	':id_lieu' => $id_lieu,
	':id_salle' => $id_salle,
	':place' => $place,
	':deve_month' => $deve_month,
	':deve_day' => $deve_day,
	':03' => $zt,
	':36' => $ts,
	':612' => $sd,
	':12' => $dp,
	':adulte' => $ad));
}

function modifType($id, $name_type, $name_event, $description, $id_lieu, $id_salle, $place, $deve_month, $deve_day, $zt, $ts, $sd, $dp, $ad)
{
	global $db;
	global $database;

	$req = $db->prepare('UPDATE '.$database.'.`type` SET `nom_type` = :nom_type, `nom_event` = :nom_event, `description` = :description, `id_lieu` = :id_lieu, `id_salle` = :id_salle, `nb_place` = :place, `deve_month` = :deve_month, `deve_day` = :deve_day, `03` = :03, `36` = :36, `612` = :612, `12` = :12, `adulte` = :adulte WHERE id=:id');
	$req->execute(array(
	':id' => $id,	
	':nom_type' => $name_type,
	':nom_event' => $name_event,
	':description' => $description,
	':id_lieu' => $id_lieu,
	':id_salle' => $id_salle,
	':place' => $place,
	':deve_month' => $deve_month,
	':deve_day' => $deve_day,
	':03' => $zt,
	':36' => $ts,
	':612' => $sd,
	':12' => $dp,
	':adulte' => $ad));
}

function supprType($id)
{
	global $db;
	global $database;

	$req = $db->prepare('DELETE FROM '.$database.'.`type` WHERE id=:id');
	$req->execute(array(':id' => $id));
}

function getAllType()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT id, nom_type FROM '.$database.'.`type`');
	$req->execute();
	$res = $req->fetchAll();
	array_push($res, array('id' => '0', 'nom_type' => 'Aucun'));
	return ($res);
}

function getTypeByName($name)
{
	global $db;
	global $database;

	if ($name == "Aucun")
		return 0;
	$req = $db->prepare('SELECT id, nom_type FROM '.$database.'.`type` WHERE nom_type=:name');
	$req->execute(array(':name' => $name));
	$res = $req->fetchAll();
	return ($res[0]);
}

function getTypeById($id)
{
	global $db;
	global $database;

	if ($id == 0)
		return array('id' => 0,
					 'nom_type' => 'aucun',
					 'nom_event' => null,
					 'description' => null,
					 'id_lieu' => 0,
					 'id_salle' => 0,
					 'nb_place' => 0,
					 'deve_month' => 0,
					 'deve_day' => 0,
					 '03' => 0,
					 '36' => 0,
					 '612' => 0,
					 '12' => 0,
					 'adulte' => 0);
	$req = $db->prepare('SELECT id, nom_type FROM '.$database.'.`type` WHERE nom_type=:name');
	$req->execute(array(':name' => $name));
	$res = $req->fetchAll();
	return ($res[0]);
}
?>