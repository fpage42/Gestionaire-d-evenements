<?php
include_once($root['view']['password']);
include_once($root['model']['mail']);
include_once($root['model']['evenement']);
include_once($root['model']['lieu']);
include_once($root['model']['salle']);

$file = fopen("data/mail", "a+");

if (isset($_GET['action']))
{
	switch ($_GET['action'])
	{
		case "registerMail" :
			if (isset($_POST['nom']) && isset($_POST['expediteur']) && isset($_POST['objet']) && isset($_POST['content']))
			{
				saveContent(fgets($file));
				fclose($file);
				header('Location: ?href=config_mail');
			}
			break;
		case "testMail" :
				$event = getNextEvent()[0];
				if ($event == null)
				{
					echo "Aucun evenement trouvé.";
					exit();
				}
				$inscrit['id'] = 0;
				$inscrit['id_event'] = $event['id'];
				$inscrit['nom'] = "Nom_test";
				$inscrit['prenom'] = "Prenom_test";
				$inscrit['email'] = $_POST['data'];
				$inscrit['telephone'] = 0666666666;
				$inscrit['age'] = 18;
				$inscrit['mois'] = 0;
				$inscrit['comment'] = "";
				sendmailparse($inscrit, $event);
				header('location: ?href=config_mail');
			break;
		case "toggleActive":
			toggleMailActive();
			header('location: ?href=config_mail');
	}
}
else
	include_once($root['view']['config_mail']);

function saveContent($active)
{
	global $file;
	
	ftruncate($file, 0);
	fputs($file, $active);
	fputs($file, $_POST['nom']."\n");
	fputs($file, $_POST['expediteur']."\n");
	fputs($file, $_POST['objet']."\n");
	fputs($file, $_POST['content']);
}
?>