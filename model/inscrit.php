<?php

function addInscrit($idEvent, $nom, $prenom, $email, $tel, $age, $mois, $comment)
{
	global $db;
	global $database;

	$req = $db->prepare('INSERT INTO '.$database.'.`inscrit` (`id_event`, `nom`, `prenom`, `email`, `telephone`, `age`, `mois`, `comment`) VALUE (:event, :nom, :prenom, :email, :tel, :age, :mois, :comment)');
	$req->execute(array(":event" => $idEvent,
					    ":nom" => $nom,
					    ":prenom" => $prenom,
					    ":email" => $email,
					    ":tel" => $tel,
					    ":age" => $age,
					    ":mois" => $mois,
					    ":comment" => $comment));
}

function getInscrit($event_id)
{
	global $db;
	global $database;

	$req = $db->prepare('SELECT * FROM '.$database.'.`inscrit` WHERE `id_event`=:event');
	$req->execute(array(':event' => $event_id));
	$res = $req->fetchAll();
	return $res;
}

function remInscrit($idInscrit)
{
	global $db;
	global $database;

	$req = $db->prepare('DELETE FROM '.$database.'.`inscrit` WHERE id=:id');
	$req->execute(array(":id" => $idInscrit));
}

function modifInscrit($idInscrit, $nom, $prenom, $email, $tel, $age, $mois, $comment)
{
	global $db;
	global $database;

	$req = $db->prepare('UPDATE '.$database.'.`inscrit` SET nom=:nom, prenom=:prenom, email=:email, telephone=:tel, age=:age, mois=:mois, comment=:comment WHERE id=:id');
	$req->execute(array(":id" => $idInscrit,
					    ":nom" => $nom,
					    ":prenom" => $prenom,
					    ":email" => $email,
					    ":tel" => $tel,
					    ":age" => $age,
					    ":mois" => $mois,
					    ":comment" => $comment));
}

?>