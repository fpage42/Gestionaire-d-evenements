<div class="row">
          <div class="col-lg-2">
          <ul class="list-unstyled">

<?php
$listEvent = getPastEvent();
foreach($listEvent as $elem)
{
		echo '<li><a href="#" id="btn_evenement_'.$elem["id"].'">'.$elem['nom_event'].'</a></li>';
}
?>
			  </ul>
          </div>
<div class="col-lg-10">
<?php



foreach ($listEvent as $elem)
{
		echo '<div id=evenement_'.$elem['id'].'>';
		
		echo '<div class="btn-group" data-toggle="buttons">
		<label>Préciser les personnes présentes :</label>
		<input id="btn_evenement_'.$elem["id"].'_meth" type="checkbox" data-off-text="non" data-on-text="oui" class="BSswitch">
</label>
</div>';
		echo '<div id="evenement_'.$elem['id'].'_meth_1">';
		$listInscrit = getInscrit($elem['id']);	
		echo '<form class="well" method="post" action="?href=archivage&action=presence&data='.$elem["id"].'&nbCheckBox='.sizeof($listInscrit).'"><table>';
		$a = 0;
		foreach ($listInscrit as $elem2)
		{
			echo '<tr><td height=50><label>'.$elem2['nom'].' '.$elem2['prenom'].': &nbsp;&nbsp;&nbsp;</label></td><td><input name="box_'.$a.'" class="BSswitch" type="checkbox" data-off-text="Non présent" data-on-text="Présent" data-off-color="danger"></td></tr>';
			$a++;
		}
		echo '</table>
		<div class="form-group">
		<label> Nombre de personnes supplémentaires :</label>
		<input name="personneSupple" type="number" class="form-control" value="0"></div><input class="btn btn-primary form-control" type="submit" value="Archiver"></form>
		<form action="?href=archivage&action=addInscrit&data='.$elem['id'].'" method="post">
		<div class="form-group">
		<label>Inscription de personnes supplémentaire</label>
		<table class="table">	
		<tr class="active"><td><strong>Nom<span style="color:red">*</span></strong></td><td><strong>Prénom<span style="color:red">*</span></strong></td><td><strong>Email</strong></td><td><strong>Téléphone</strong></td><td><strong>Age</strong></td><td><strong>Mois</strong></td><td><strong>Commentaire</strong></td><td><strong>Gestion</strong></td></tr>
		<tr><td><input name="nom" type="texte" class="form-control"></td>
		<td><input name="prenom" type="texte" class="form-control"></td>
		<td><input name="email" type="texte" class="form-control"></td>
		<td><input name="telephone" type="texte" class="form-control"></td>
		<td><input name="age" type="number" class="form-control"></td>
		<td><input name="mois" type="number" class="form-control"></td>
		<td><input name="comment" type="texte" class="form-control"></td>
		<td><input value="Inscrire" type="submit" class="btn btn-primary"></td></tr></table>
		</div>
		</form>
		</div>';
		
		echo '<div id="evenement_'.$elem['id'].'_meth_2">
		<form class="well" method="post" action="?href=archivage&action=nb_personne&data='.$elem["id"].'">
		<div class="form-group">
		<label>Nombre de personnes présente :</label>
			<input name="personnePres" class="form-control" type="number" value="0">
		</div><div class="form-group">
			<input class="btn btn-primary form-control" type="submit" value="Archiver">
		</div>
		</form>
		</div>';
		echo '</div>';
}
?>

</div>
    </div>
	
<script>
$(function() {

$('.BSswitch').bootstrapSwitch('state', true);

<?php

foreach ($listEvent as $elem)
{
	echo "$('#evenement_".$elem['id']."').hide();
	$('#evenement_".$elem['id']."_meth_2').hide();
	$('#btn_evenement_".$elem['id']."').click(function()  {
		showEvenement('#evenement_".$elem['id']."');
			});
$('#btn_evenement_".$elem['id']."_meth').on('switchChange.bootstrapSwitch', function () {
	if ($('#btn_evenement_".$elem['id']."_meth').bootstrapSwitch('state') == true)
	{
		$('#evenement_".$elem['id']."_meth_1').slideDown();
		$('#evenement_".$elem['id']."_meth_2').slideUp();
	}
	else
	{
		$('#evenement_".$elem['id']."_meth_2').slideDown();
		$('#evenement_".$elem['id']."_meth_1').slideUp();
	}
});
			
	$('#btn_evenement_".$elem['id']."_meth_2').click(function()  {
	$('#evenement_".$elem['id']."_meth_2').slideDown();
	$('#evenement_".$elem['id']."_meth_1').slideUp();
});";
}
echo "function showEvenement(evenement_id) {";
foreach ($listEvent as $elem)
{
	echo "$('#evenement_".$elem['id']."').slideUp();";
}
echo "$(evenement_id).slideDown();}";
?>	
});
</script>