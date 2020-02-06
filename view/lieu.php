<div class="row">
<form method="post" action="?href=lieu&action=addlieu" class="well col-lg-offset-2 col-lg-8">
    <div class="form-group">
        <label>Nom du lieu:</label>
        <input name="name" type="text" class="form-control">
    </div>
	<div class="form-group">
        <label>Téléphone:</label>
        <input name="tel" type="text" class="form-control">
    </div>
        <input type="submit" value="Valider" class="btn btn-primary form-control">
</form>

<div class="row">

<table class="table">
<?php
$listeLieu = getAllLieu();
foreach ($listeLieu as $value)
	echo '<tr><td>'.$value['nom'].'</td><td>'.$value['telephone'].'</td><td><a href="?href=lieu&action=suppr&data='.$value['id'].'"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';

?>
</table>
</div>
</div>
