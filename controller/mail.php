<?php
include_once($root['model']['mail']);
include_once($root['model']['evenement']);
include_once($root['model']['inscrit']);
include_once($root['model']['lieu']);
include_once($root['model']['salle']);
if (isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case 'mail24':
			$event = getEventTomorow();
			foreach ($event as $elem)
			{
				$insc = getInscrit($elem['id']);
				foreach ($insc as $inscrit)
				{
					sendmailparse($inscrit, $elem);
				}
			}
	}
}
?>