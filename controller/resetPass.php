<?php

include_once($root['view']['password']);

if (isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['confPass']))
{
	if ($_POST['oldPass'] == "")
		header('location: ?href=resetPass&err=oldPass');
	else if ($_POST['newPass'] == "")
		header('location : ?href=resetPass&err=newPass');
	else if ($_POST['confPass'] == "")
		header('location: ?href=resetPass&err=confPass');
	else if ($_POST['newPass'] != $_POST['confPass'])
		header('location: ?href=resetPass&err=notSim');
	else if ($_POST['oldPass'] != $_SESSION['pass'])
		header('location: ?href=resetPass&err=passErr');
	else
	{
		$file = fopen('data/password', 'c+');
		ftruncate($file, 0);
		fputs($file, $_POST['newPass']);
		header("Location: index.php");
	}
}

if (isset($_GET['err']))
	switch ($_GET['err'])
	{
		case "oldPass" :
			echo getMessageError("Il semblerai que le champs ancien mot de passe soit vide");
			break;
		case "newPass" :
			echo getMessageError("Il semblerai que le champs nouveau mot de passe soit vide");
			break;
		case "confPass" :
			echo getMessageError("Il semblerai que le champs confirmation du mot de passe soit vide");
			break;
		case "notSim" :
			echo getMessageError("Il semblerai que le champs nouveau mot de passe et confirmation du mot de passe ne corresponde pas");
			break;
		case "passErr" :
			echo getMessageError("Il semblerai que le champs ancien mot de passe soit incorrect");
			break;
	}

	
	
	function getMessageError($phrase)
	{
		return '<div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Erreur!</strong>'.$phrase.'</div>';
	}
	
	echo '
<form class="well" action="?href=resetPass" method="post">
<div class="form-group">
	<label>Ancien mot de passe</label>
	<input class="form-control" type="password" name="oldPass">
</div>
<div class="form-group">
	<label>Nouveau mot de passe</label>
	<input class="form-control" type="password" name="newPass">
</div>
<div class="form-group">
	<label>Confirmation du mot de passe</label>
	<input class="form-control" type="password" name="confPass">
</div>
	<input class="btn btn-info" type="submit" value="Changer le mot de passe">
</form>';

?>