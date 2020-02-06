<?php

include_once("/var/www/html/evenement/root.php");
include_once("/var/www/html/evenement/include/mysql.php");
include_once($root['model']['mail']);
include_once($root['model']['evenement']);
include_once($root['model']['inscrit']);
include_once($root['model']['lieu']);
include_once($root['model']['salle']);

$event = getEventTomorow();
foreach ($event as $elem)
{
	$insc = getInscrit($elem['id']);
	foreach ($insc as $inscrit)
		sendmailparse($inscrit, $elem);
}
?>