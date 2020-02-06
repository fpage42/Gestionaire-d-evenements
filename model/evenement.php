<?php

function insertEvenement($name_event, $description, $id_lieu, $id_salle, $place, $date, $hour, $deve_month, $deve_day, $zt, $ts, $sd, $dp, $ad, $type)
{
	global $db;
	global $database;

	$req = $db->prepare('INSERT INTO '.$database.'.`evenement` (`nom_event`, `description`, `id_lieu`, `id_salle`, `nb_place`, `timestamp`, `deve_month`, `deve_day`, `03`, `36`, `612`, `12`, `adulte`, `type_id`) VALUES (:nom_event, :description, :id_lieu, :id_salle, :place, :timestamp, :deve_month, :deve_day, :03, :36, :612, :12, :adulte, :type)');

	$date = explode('-', $date);
	$hour = explode(':', $hour);

	$req->execute(array(
	':nom_event' => $name_event,
	':description' => $description,
	':id_lieu' => $id_lieu,
	':id_salle' => $id_salle,
	':place' => $place,
	':timestamp' => $date[0].$date[1].$date[2].$hour[0].$hour[1].'00',
	':deve_month' => $deve_month,
	':deve_day' => $deve_day,
	':03' => $zt,
	':36' => $ts,
	':612' => $sd,
	':12' => $dp,
	':adulte' => $ad,
	':type' => $type));
}

function modifEvenement($id, $name_event, $description, $id_lieu, $id_salle, $place, $date, $hour, $deve_month, $deve_day, $zt, $ts, $sd, $dp, $ad)
{
	global $db;
	global $database;

	$req = $db->prepare('UPDATE '.$database.'.`evenement` SET `nom_event`=:nom_event, `description`=:description, `id_lieu`=:id_lieu, `id_salle`=:id_salle, `nb_place`=:place, `timestamp`=:timestamp, `deve_month`=:deve_month, `deve_day`=:deve_day, `03`=:zt, `36`=:ts, `612`=:sd, `12`=:dp, `adulte`=:ad WHERE id=:id');

	$date = explode('-', $date);
	$hour = explode(':', $hour);

	$req->execute(array(
	':id' => $id,
	':nom_event' => $name_event,
	':description' => $description,
	':id_lieu' => $id_lieu,
	':id_salle' => $id_salle,
	':place' => $place,
	':timestamp' => $date[0].$date[1].$date[2].$hour[0].$hour[1].'00',
	':deve_month' => $deve_month,
	':deve_day' => $deve_day,
	':zt' => $zt,
	':ts' => $ts,
	':sd' => $sd,
	':dp' => $dp,
	':ad' => $ad));
}

function supprEvent($id)
{
	global $db;
	global $database;
	
	$req = $db->prepare('DELETE FROM '.$database.'.`evenement` WHERE id=:id');
	$req->execute(array(':id' => $id));
	$req = $db->prepare('delete FROM '.$database.'.`inscrit` WHERE id_event=:id_event');
	$req->execute(array(':id_event' => $id));
}

function getAllEvent()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`evenement` ORDER BY timestamp ASC');
	$req->execute();
	$res = $req->fetchAll();

	return $res;
}

function getEvent($id)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`evenement` WHERE id=:id');
	$req->execute(array(':id' => $id));
	$res = $req->fetchAll();

	return $res[0];
}

function getNbPlace($id)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT nb_place FROM '.$database.'.`evenement` WHERE id=:id');
	$req->execute(array(':id' => $id));
	$res = $req->fetchAll();

	return $res[0]['nb_place'];
}

function getPastEvent()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`evenement` WHERE timestamp < NOW() ORDER BY timestamp ASC');
	$req->execute();
	$res = $req->fetchAll();

	return $res;
}

function getNextEvent()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`evenement` HAVING MIN(timestamp)');
	$req->execute();
	$res = $req->fetchAll();

	return $res;
}

function getEventTomorow()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`evenement` WHERE timestamp > NOW() && (timestamp < NOW() + INTERVAL 2 DAY) ORDER BY timestamp ASC');
	$req->execute();
	$res = $req->fetchAll();

	return $res;	
}
?>