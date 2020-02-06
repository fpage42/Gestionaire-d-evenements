<div class="row">
<form method="post" action="?href=salle&action=addSalle" class="well col-lg-offset-2 col-lg-8">
    <div class="form-group">
        <label>Lieu:</label>
        <select name="lieu" class="form-control">
		<?php
		$allLieu = getAllLieu();
		foreach ($allLieu as $value)
			echo ' <option value='.$value["id"].'>'.$value["nom"].'</option>';
		?>
        </select>
    </div>
    <div class="form-group">
        <label>Nom de la salle:</label>
        <input name="name" type="text" class="form-control">
    </div>
        <input type="submit" value="Valider" class="btn btn-primary form-control">
</form>

<div class="row">

<table class="table">
<?php
$listeLieu = getAllLieu();
foreach ($listeLieu as $val)
{
	$listeSalle = getSalleByLieu($val['id']);
		echo '<tr><td colspan=2><center><b>'.$val['nom'].'</b></center></td></tr>';
	foreach ($listeSalle as $value)
		echo '<tr><td>'.$value['nom'].'</td><td><a href="?href=salle&action=suppr&data='.$value['id'].'"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';
}

?>
</table>
</div>
</div>
