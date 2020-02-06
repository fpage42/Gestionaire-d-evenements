<?php

include_once($root['model']['archive_evenement']);
include_once($root['model']['archive_inscrit']);
include_once($root['model']['lieu']);
include_once($root['model']['salle']);

$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aoùt","Septembre","Octobre","Novembre","Décembre");

if (isset($_GET['post']))
		header('location: ?href=archive&dateDebut='.$_POST['dateDebut'].'&dateFin='.$_POST['dateFin'].'&type='.$_POST['type'].'&lieu='.$_POST['lieu'].'&salle='.$_POST['salle'].'&age='.$_POST['age']);
if (isset($_GET['dateDebut']) || isset($_GET['dateFin']) || isset($_GET['type']) ||
	isset($_GET['lieu']) || isset($_GET['salle']) || isset($_GET['age']))
	include_once($root['view']['archive']);
else
	include_once($root['view']['selectArchive']);
	


function formatEvenement($databaseEvent)
{
	global $jour;
	global $mois;
	$i = 0;
	$timestampEvent = mktime(substr($databaseEvent["timestamp"], 11, 2),
				 	 substr($databaseEvent["timestamp"], 14, 2),
					 substr($databaseEvent["timestamp"], 17, 2),
					 substr($databaseEvent["timestamp"], 5, 2),
					 substr($databaseEvent["timestamp"], 8, 2),
					 substr($databaseEvent["timestamp"], 0, 4));
	echo '<div class="col-lg-10" id="evenement_'.$databaseEvent["id"].'">
	<div style="color:black; font-size: 120%" class="alert span5 alert-success">'.$databaseEvent["description"].'<br /><br /><table>
	<tr><td>Date</td><td> &nbsp;&nbsp;&nbsp;'.$jour[date("w", $timestampEvent)]." ".date("d", $timestampEvent)." ".$mois[date("n", $timestampEvent)]." ".date("Y", $timestampEvent).' à '.substr($databaseEvent["timestamp"], 11, 5).'
	</td></tr><tr><td>Lieu </td><td>&nbsp;&nbsp;&nbsp;'.$databaseEvent['lieu'].
	'</td></tr><tr><td>Salle </td><td>&nbsp;&nbsp;&nbsp;'.$databaseEvent['salle'].'<br>'.
	'</td></tr><tr><td>Type </td><td>&nbsp;&nbsp;&nbsp;'.$databaseEvent['type'].'<br>';
	echo '</td></tr><tr><td>Présences</td><td>&nbsp;&nbsp;&nbsp;'.nbPres($databaseEvent['id']).'/'.nbInscrit($databaseEvent["id"]).'</td></tr></table>
	</div>
	<table class="table">
	<tr class="active"><td><strong>Nom</strong></td><td><strong>Prénom</strong></td><td><strong>Email</strong></td><td><strong>Téléphone</strong></td><td><strong>Age</strong></td><td><strong>Mois</strong><td><strong>Comment</strong></td></tr>';
	$listInscrit = getArchiveInscrit($databaseEvent["id"]);
	foreach ($listInscrit as $elem)
	{
		echo '<tr class="';
		if ($elem["present"] == 0)
			echo " danger";
		else if ($elem["present"] == 1)
			echo " success";
		echo '"><td class="tab_nom">'.$elem["nom"].'</td><td class="tab_prenom">'.$elem["prenom"].'</td><td>'.$elem["email"].'</td><td>'.$elem["telephone"].'</td><td>';
		if ($elem["age"] != 0)
			echo $elem["age"];
		echo '</td><td>';
		
		if ($elem["mois"] != 0)
			echo $elem['mois'];
			echo "</td><td>".$elem['comment']."</tr>";
	}
	echo '</table></div>';
	$i++;
}

?>