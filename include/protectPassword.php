<?php 
if (isset($_SESSION['pass']) && $_SESSION['pass'] == $config['pass'])
{}
else
{
echo '
<form class="well" method="post" action="?href=connect&href_a='.$_GET["href"].'">
	<div class="form-group">
	<label>Mot de passe :</label>
	<input class="form-control" type="password" name="password">
	</div>
	<input class="btn btn-info" type="submit" value="Valider">
</form>';

exit();}