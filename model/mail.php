<?php

include_once("/var/www/html/evenement/include/PHPMailer/class.phpmailer.php");
include_once("/var/www/html/evenement/include/PHPMailer/class.smtp.php");

function isMailActive()
{
$file = fopen("/var/www/html/evenement/data/mail", "r+");

	$etat = fgets($file);
	if (substr($etat, 0, 3) == "off")
		return false;
	else if(substr($etat, 0, 2) == "on")
		return true;
}
function toggleMailActive()
{
	if (isMailActive())
		$active = "off";
	else
		$active = "on";
	$file = fopen("/var/www/html/evenement/data/mail", "r+");
	fgets($file);

	$nom = fgets($file);
	$expediteur = fgets($file);
	$objet = fgets($file);
	$content = null;
	while ($text = fgets($file))
		$content = $content.$text;
	fclose($file);
	$file = fopen("/var/www/html/evenement/data/mail", "r+");
	ftruncate($file, 0);
	fputs($file, $active."\n");
	fputs($file, $nom);
	fputs($file, $expediteur);
	fputs($file, $objet);
	fputs($file, $content);
	fclose($file);
}

function sendmail($dest)
{
$file = fopen("/var/www/html/evenement/data/mail", "r+");

if (isMailActive())
{
	fgets($file);

	$nom = fgets($file);
	$expediteur = fgets($file);
	$objet = fgets($file);
	$content = null;
	while ($text = fgets($file))
		$content = $content.$text;

	$content = "<html><head><meta http-equiv='Content-Type' content='text/html; charset='ISO-8859-1' /></head><body>".$content."</body></html>";
		$mail = new PHPMailer();
		$mail->Host = 'hermes.capcvm.fr';
		$mail->IsSMTP();
		$mail->SMTPAuth = false;
		$mail->Port = 25; // Par défaut
		$mail->CharSet="UTF-8";
	// Expéditeur
		$mail->SetFrom($expediteur, $nom);
	// Destinataire
		$mail->AddAddress($dest);
	// Objet
		$mail->Subject = $objet;
	// Votre message
		$mail->MsgHTML($content);
	 
	// Envoi du mail avec gestion des erreurs
		if(!$mail->Send())
		{
			echo 'Erreur : ' . $mail->ErrorInfo;
		}
		else
		{
			echo 'Message envoyé !';
		}
	}
}

function sendmailparse($inscrit, $event)
{
	if (!isMailActive() || !isset($inscrit['email']))
		return;
	$file = fopen("/var/www/html/evenement/data/mail", "r+");

	fgets($file);
	$nom = fgets($file);
	$expediteur = fgets($file);
	$objet = fgets($file);
	$content = null;
	while ($text = fgets($file))
		$content = $content.$text;

	$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
	$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

	$timestampEvent = mktime(substr($event["timestamp"], 11, 2),
						 	 substr($event["timestamp"], 14, 2),
							 substr($event["timestamp"], 17, 2),
							 substr($event["timestamp"], 5, 2),
							 substr($event["timestamp"], 8, 2),
							 substr($event["timestamp"], 0, 4));
							 
	$content = "<html><head><meta http-equiv='Content-Type' content='text/html; charset='ISO-8859-1' /></head><body>".$content."</body></html>";
	$split = preg_split('/(\[)([a-z,_]*)(])/', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	$mess="";
	foreach ($split as $elem)
	{
		if ($elem == '[' || $elem == ']')
		{}
		else if ($elem == 'nom_utilisateur')
			$mess = $mess.$inscrit['nom'];
		else if ($elem == 'prenom_utilisateur')
			$mess = $mess.$inscrit['prenom'];
		else if ($elem == 'age_utilisateur' && isset($inscrit['age']))
			$mess = $mess.$inscrit['age'];
		else if ($elem == 'evenement')
			$mess = $mess.$event['nom_event'];
		else if ($elem == 'date')
			$mess = $mess.$jour[date("w", $timestampEvent)]." ".date("d", $timestampEvent)." ".$mois[date("n", $timestampEvent)]." ".date("Y", $timestampEvent);
		else if ($elem == 'heure')
			$mess = $mess.substr($event['timestamp'], 10, 6);
		else if ($elem == 'lieu')
			$mess = $mess.getLieuById($event['id_lieu'])['nom'];
		else if ($elem == 'salle')
			$mess = $mess.getSalleById($event['id_salle'])['nom'];
		else if ($elem == 'telephone')
			$mess = $mess.getLieuById($event['id_lieu'])['telephone'];
		else
			$mess = $mess.$elem;
	}
	$mess = preg_replace("/\\n/","<br />",$mess);

	$mail = new PHPMailer();
	$mail->Host = 'hermes.capcvm.fr';
	$mail->IsSMTP();
	$mail->SMTPAuth = false;
	$mail->Port = 25; // Par défaut
	$mail->CharSet="UTF-8";
	// Expéditeur
	echo $expediteur."<br />";
	echo $nom."<br />";
	$mail->SetFrom($expediteur, $nom);
	// Destinataire
	$mail->AddAddress($inscrit['email']);
	// Objet
	$mail->Subject = $objet;
	// Votre message
	$mail->MsgHTML($mess);
	 
	// Envoi du mail avec gestion des erreurs
	if(!$mail->Send())
	{
		echo 'Erreur : ' . $mail->ErrorInfo;
	}
	else
	{
		echo 'Message envoyé !';
	}
}
?>