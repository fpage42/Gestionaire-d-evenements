<?php

function addArchiveInscrit($idEvent, $idArchive, $id, $presence)
{
	global $db;
	global $database;
	
	$req = $db->prepare('SELECT * FROM '.$database.'.`inscrit` WHERE id_event=:event ORDER BY id');
	$req->execute(array(':event' => $idEvent));
	$res = $req->fetchAll();
	$req = $db->prepare('INSERT INTO '.$database.'.`archive_inscrit` (`id_event`, `nom`, `prenom`, `email`, `telephone`, `age`, `mois`, `comment`, `present`) VALUE (:event, :nom, :prenom, :email, :tel, :age, :mois, :comment, :present)');
	$req->execute(array(":event" => $idArchive,
			    ":nom" => $res[$id]['nom'],
			    ":prenom" => $res[$id]['prenom'],
			    ":email" => $res[$id]['email'],
			    ":tel" => $res[$id]['telephone'],
			    ":age" => $res[$id]['age'],
			    ":mois" => $res[$id]['mois'],
				":comment" => $res[$id]['comment'],
				":present" => ($presence) ? 1 : 0
				));
}

function archiveAllInscrit($idEvent, $idArchive)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`inscrit` WHERE id_event=:event ORDER BY id DESC');
	$req->execute(array(':event' => $idEvent));
	$res = $req->fetchAll();
	foreach($res as $elem)
	{
		$req = $db->prepare('INSERT INTO '.$database.'.`archive_inscrit` (`id_event`, `nom`, `prenom`, `email`, `telephone`, `age`, `mois`, `comment`, `present`) VALUE (:event, :nom, :prenom, :email, :tel, :age, :mois, :comment, :present)');
		$req->execute(array(":event" => $idArchive,
			    ":nom" => $elem['nom'],
			    ":prenom" => $elem['prenom'],
			    ":email" => $elem['email'],
			    ":tel" => $elem['telephone'],
			    ":age" => $elem['age'],
			    ":mois" => $elem['mois'],
			    ":comment" => $elem['comment'],
				":present" => 2));

	}
}

function getArchiveInscrit($event_id)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`archive_inscrit` WHERE `id_event`=:event');
	$req->execute(array(':event' => $event_id));
	$res = $req->fetchAll();
	return $res;
}

function nbPres($event_id)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT COUNT(*) FROM '.$database.'.`archive_inscrit` WHERE `id_event`=:event && present=1');
	$req->execute(array(':event' => $event_id));
	$res = $req->fetchAll();
	return $res[0]['COUNT(*)'];
}

function nbInscrit($event_id)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT COUNT(*) FROM '.$database.'.`archive_inscrit` WHERE `id_event`=:event');
	$req->execute(array(':event' => $event_id));
	$res = $req->fetchAll();
	return $res[0]['COUNT(*)'];
}
?>