<?php

function archiveEvent($meth, $idEvent, $nbPers)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`evenement` WHERE id=:id');
	$req->execute(array(':id' => $idEvent));
	$res = $req->fetchAll();
	$req = $db->prepare('INSERT INTO '.$database.'.`archive_evenement`
							(`nom_event`, `description`, `lieu`, `salle`, `nb_place`, `timestamp`, `deve_month`, `deve_day`, `meth`, `nb_pres`, `03`, `36`, `612`, `12`, `adulte`, `type`)
						VALUES (:nom_event, :description, :lieu, :salle, :place, :timestamp, :deve_month, :deve_day, :meth, :pres, :zt, :ts, :sd, :dp, :ad, :type)');
	$req->execute(array(
		':nom_event' => $res[0]['nom_event'],
		':description' => $res[0]['description'],
		':lieu' => getLieuById($res[0]['id_lieu'])['nom'],
		':salle' => getSalleById($res[0]['id_salle'])['nom'],
		':place' => $res[0]['nb_place'],
		':timestamp' => $res[0]['timestamp'],
		':deve_month' => $res[0]['deve_month'],
		':deve_day' => $res[0]['deve_day'],
		':zt' => $res[0]['03'],
		':ts' => $res[0]['36'],
		':sd' => $res[0]['612'],
		':dp' => $res[0]['12'],
		':ad' => $res[0]['adulte'],
		':type' => getTypeById($res[0]['type_id'])['nom_type'],
		':meth' => $meth,
		':pres' => $nbPers));
	$req = $db->prepare('SELECT id FROM '.$database.'.`archive_evenement` WHERE id=(SELECT MAX(id) FROM '.$database.'.`archive_evenement`)');
	$req->execute();
	$res = $req->fetchAll();
	return ($res[0]['id']);
}

function getArchive($dateDebut, $dateFin, $lieu, $type, $salle, $age)
{
	global $db;
	global $database;
	
	if ($lieu != "" && $salle == "" && $type == "" && $age == "")
		$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && lieu = :lieu ORDER BY timestamp';
	else if ($salle != "" && $lieu == "" && $type == "" && $age == "")
		$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle ORDER BY timestamp';
	else if ($type != "" && $lieu == "" && $type == "" && $age == "")
		$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type ORDER BY timestamp';
	else if ($age != "" && $lieu == "" && $type == "" && $type == "")
	{
		if ($age == '03')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && 03 = true ORDER BY timestamp';
		else if ($age == '36')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && 36 = true ORDER BY timestamp';
		else if ($age == '612')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && 612 = true ORDER BY timestamp';
		else if ($age == '12+')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && 12 = true ORDER BY timestamp';
		else if ($age == 'adulte')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && adulte = true ORDER BY timestamp';
	}
	else if ($lieu != "" && $salle != "" && $type == "" && $age == "")
		$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && lieu = :lieu && salle = :salle ORDER BY timestamp';
	else if ($lieu != "" && $type != "" && $salle == "" && $age == "")
		$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && lieu = :lieu && type = :type ORDER BY timestamp';
	else if ($type != "" && $salle != "" && $lieu == "" && $age == "")
		$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type ORDER BY timestamp';
	else if ($age != "" && $salle != "" && $lieu == "" && $type == "")
	{
		if ($age == '03')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && 03 = true ORDER BY timestamp';
		else if ($age == '36')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && 36 = true ORDER BY timestamp';
		else if ($age == '612')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && 612 = true ORDER BY timestamp';
		else if ($age == '12+')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && 12 = true ORDER BY timestamp';
		else if ($age == 'adulte')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && adulte = true ORDER BY timestamp';
	}
	else if ($age != "" && $lieu != "" && $salle == "" && $type == "")
	{
		if ($age == '03')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && lieu = :lieu && 03 = true ORDER BY timestamp';
		else if ($age == '36')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && lieu = :lieu && 36 = true ORDER BY timestamp';
		else if ($age == '612')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && lieu = :lieu && 612 = true ORDER BY timestamp';
		else if ($age == '12+')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && lieu = :lieu && 12 = true ORDER BY timestamp';
		else if ($age == 'adulte')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && lieu = :lieu && adulte = true ORDER BY timestamp';
	}
	else if ($age != "" && $type != "" && $lieu == "" && $salle == "")
	{
		if ($age == '03')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && 03 = true ORDER BY timestamp';
		else if ($age == '36')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && 36 = true ORDER BY timestamp';
		else if ($age == '612')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && 612 = true ORDER BY timestamp';
		else if ($age == '12+')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && 12 = true ORDER BY timestamp';
		else if ($age == 'adulte')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && adulte = true ORDER BY timestamp';
	}
	else if ($type != "" && $salle != "" && $lieu != "" && $age == "")
		$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && lieu = :lieu ORDER BY timestamp';
	else if ($age != "" && $salle != "" && $lieu != "" && $type == "")
	{
		if ($age == '03')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && lieu = :lieu && 03 = true ORDER BY timestamp';
		else if ($age == '36')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && lieu = :lieu && 36 = true ORDER BY timestamp';
		else if ($age == '612')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && lieu = :lieu && 612 = true ORDER BY timestamp';
		else if ($age == '12+')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && lieu = :lieu && 12 = true ORDER BY timestamp';
		else if ($age == 'adulte')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && lieu = :lieu && adulte = true ORDER BY timestamp';
	}
	else if ($age != "" && $type != "" && $lieu != "" && $salle == "")
	{
		if ($age == '03')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && 03 = true ORDER BY timestamp';
		else if ($age == '36')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && 36 = true ORDER BY timestamp';
		else if ($age == '612')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && 612 = true ORDER BY timestamp';
		else if ($age == '12+')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && 12 = true ORDER BY timestamp';
		else if ($age == 'adulte')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && adulte = true ORDER BY timestamp';
	}
	else if ($age != "" && $salle != "" && $type != "" && $lieu == "")
	{
		if ($age == '03')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && 03 = true ORDER BY timestamp';
		else if ($age == '36')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && 36 = true ORDER BY timestamp';
		else if ($age == '612')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && 612 = true ORDER BY timestamp';
		else if ($age == '12+')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && 12 = true ORDER BY timestamp';
		else if ($age == 'adulte')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && salle = :salle && type = :type && adulte = true ORDER BY timestamp';
	}
	else if ($age != "" && $salle != "" && $lieu != "" && $type != "")
	{
		if ($age == '03')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && salle = :salle && lieu = :lieu && 03 = true ORDER BY timestamp';
		else if ($age == '36')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && salle = :salle && lieu = :lieu && 36 = true ORDER BY timestamp';
		else if ($age == '612')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && salle = :salle && lieu = :lieu && 612 = true ORDER BY timestamp';
		else if ($age == '12+')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && salle = :salle && lieu = :lieu && 12 = true ORDER BY timestamp';
		else if ($age == 'adulte')
			$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut && type = :type && salle = :salle && lieu = :lieu && adulte = true ORDER BY timestamp';
	}
	else
		$strReq = 'SELECT * FROM '.$database.'.`archive_evenement` WHERE timestamp < :fin && timestamp > :debut ORDER BY timestamp';

	$req = $db->prepare($strReq);
	$argsSql = array(':fin' => $dateFin,
					':debut' => $dateDebut);
	if ($lieu != "")
		$argsSql[':lieu'] = $lieu;
	if ($salle != "")
		$argsSql[':salle'] = $salle;
	if ($type != "")
		$argsSql[':type'] = $type;
	$req->execute($argsSql);
	$res = $req->fetchAll();
	return $res;
}

function nbInscritSupp($event_id)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT nb_pres FROM '.$database.'.`archive_evenement` WHERE `id`=:event');
	$req->execute(array(':event' => $event_id));
	$res = $req->fetchAll();
	return $res[0]['nb_pres'];
}

function getAllLieuArchive()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT DISTINCT lieu FROM '.$database.'.`archive_evenement`');
	$req->execute();
	$res = $req->fetchAll();
	return $res;
}

function getAllSalleArchive()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT DISTINCT salle FROM '.$database.'.`archive_evenement`');
	$req->execute();
	$res = $req->fetchAll();
	return $res;
}

function getAllTypeArchive()
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT DISTINCT type FROM '.$database.'.`archive_evenement`');
	$req->execute();
	$res = $req->fetchAll();
	return $res;
}
?>