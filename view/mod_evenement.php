<div class="row">
          <div class="col-lg-2">
          <ul id="liste_event_actif" class="list-unstyled">
<?php
$listEvent = getAllEvent();

$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$numJour = date('w');
$nbEvent = count($listEvent);
$timestampJourMin = mktime(0, 0, 0, date("n"), date("d"), date('Y'));
$timestampJourMax = $timestampJourMin + 86400;
$evenementEcrit = 0;

$i = 0;
$dateEcrit = 0;
while ($i < $nbEvent) {
	$timestampEvent = mktime(substr($listEvent[$i]["timestamp"], 11, 2),
						 	 substr($listEvent[$i]["timestamp"], 14, 2),
							 substr($listEvent[$i]["timestamp"], 17, 2),
							 substr($listEvent[$i]["timestamp"], 5, 2),
							 substr($listEvent[$i]["timestamp"], 8, 2),
							 substr($listEvent[$i]["timestamp"], 0, 4));
	if ($dateEcrit < ($timestampEvent - $timestampEvent % 86400) / 86400)
	{
		echo '<li><b>'.$jour[date("w", $timestampEvent)]." ".date("d", $timestampEvent)." ".$mois[date("n", $timestampEvent)]." ".date("Y", $timestampEvent).'</b></li>';
		$dateEcrit = $timestampEvent / 86400;
	}
	if (($timestampEvent - $timestampEvent % 86400) / 86400 <= $dateEcrit)
	{
		$timeUnlock = ($listEvent[$i]["deve_month"] * 30 + $listEvent[$i]["deve_day"]) * 86400;
		if ($timestampEvent - $timeUnlock < time())
			echo "<li><a id='btn_evenement_".$listEvent[$i]["id"]."' href=#>".$listEvent[$i]["nom_event"]."</a></li>";
		else
			echo "<li><a style='color:grey;' id='btn_evenement_".$listEvent[$i]["id"]."' href=#>".$listEvent[$i]["nom_event"]."</a></li>";

		$evenementEcrit++;
	}
	$i++;
}
?>
</ul>
</div>

	<?php
	$i = 0;
	while ($i < $nbEvent)
	{
		echo '<div class="col-lg-10" id="evenement_'.$listEvent[$i]["id"].'">
<form method="post" action="?href=mod_evenement&action=modif&data='.$listEvent[$i]["id"].'" class="well">
    <div class="form-group">
        <label>Nom de l\'évènement:</label>
        <input name="name_event" type="text" class="form-control" value="'.$listEvent[$i]["nom_event"].'">
    </div>
    <div class="form-group">
        <label>Déscription de l\'évènement:</label>
        <textarea name="description" class="form-control" rows="4">'.$listEvent[$i]["description"].'</textarea>
    </div>
    <div class="form-group">
        <label>Date:</label>
        <input name="date" type="date" placeholder="jj/mm/aaaa" class="form-control" value="'.substr($listEvent[$i]["timestamp"], 0, 10).'">
    </div>
    <div class="form-group">
        <label>Heure:</label>
        <input name="hour" type="time" placeholder="hh:mm" class="form-control" value="'.substr($listEvent[$i]["timestamp"], 11, 8).'">
    </div>';
?>

    <div class="form-group">
        <label>Lieu:</label>
        <select value='<?php echo $listEvent[$i]["id_lieu"]; ?>' id="select_lieu" name="lieu" class="form-control" onChange="changeLieu(document.getElementById('select_lieu').value);">
		<?php
		$allLieu = getAllLieu();
		$selectLieu = false;
		foreach ($allLieu as $value)
		{
			if ($value["id"] == $listEvent[$i]["id_lieu"])
			{
				echo ' <option value='.$value["id"].' selected="selected">'.$value["nom"].'</option>';
				$selectLieu = true;
			}
			else
				echo ' <option value='.$value["id"].'>'.$value["nom"].'</option>';
		}
		if ($selectLieu == false)
			echo '<option value=0 selected>Autre</option>';
		else
			echo '<option value=0>Autre</option>';
		?>

        </select>
    </div>
    <div class="form-group">
        <label>Salle de l'évènement:</label>
		<select value='<?php echo $listEvent[$i]["id_salle"]; ?>' id="select_salle" name="salle" class="form-control">
		<?php
		$allSalle = getAllSalle();
		$selectSalle = false;
		foreach ($allSalle as $value)
		{
			if ($value["id"] == $listEvent[$i]["id_salle"])
			{
				echo ' <option data-lieu='.$value["id_lieu"].' value='.$value["id"].' selected>'.$value["nom"].'</option>';
				$selectSalle = true;
			}
			else
				echo ' <option data-lieu='.$value["id_lieu"].' value='.$value["id"].'>'.$value["nom"].'</option>';
			}
			if ($selectSalle == false)
				echo '<option value=0 selected>Autre</option>';
			else
				echo '<option value=0>Autre</option>';
			?>
        </select>
</div>
    <div class="form-group">
        <label>Nombres de places:</label>
        <input name="nb_place" type="number" class="form-control" value=<?php echo $listEvent[$i]["nb_place"];?>>
    </div>
    <div class="form-group">
        <span title="1 mois = 30 jours"><label>Dévérouillage de l'évènement:<span class="glyphicon glyphicon glyphicon-pushpin"></span></label></span>
	<div class="input-group">
        <input name="deve_month" type="number" class="form-control" value=<?php  echo $listEvent[$i]["deve_month"];?>>
        <span class="input-group-addon">mois</span>
        <input name="deve_day" type="number" class="form-control" value=<?php  echo $listEvent[$i]["deve_day"];?>>
        <span class="input-group-addon">jours</span>
	</div></div>

	<?php
	echo '<table class="form-group">
		<tr><td colspan=2><label>Tranche d\'âge&nbsp;&nbsp;&nbsp;</label></td></tr>
		<tr><td><label>0-3 ans&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-03" name="0-3" type="checkbox" ';
		if ($listEvent[$i]["03"] == "1") echo "checked ";
		echo 'data-switch-no-init></td></tr>
		<tr><td><label>3-6 ans&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-36" name="3-6" type="checkbox" ';
		if ($listEvent[$i]["36"] == "1") echo "checked ";
		echo 'data-switch-no-init></td></tr>
		<tr><td><label>6-12 ans&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-612" name="6-12" type="checkbox" ';
		if ($listEvent[$i]["612"] == "1") echo "checked ";
		echo 'data-switch-no-init></td></tr>
		<tr><td><label>12 ans et plus&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-12" name="12+" type="checkbox" ';
		if ($listEvent[$i]["12"] == "1") echo "checked ";
		echo 'data-switch-no-init></td></tr>
		<tr><td><label>Adultes&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-adulte" name="adulte" type="checkbox" ';
		if ($listEvent[$i]["adulte"] == "1") echo "checked ";
		echo 'data-switch-no-init></td></tr>
	</table>

	<input type="submit" value="Valider" class="btn btn-primary form-control col-lg-3">
</form><br />
          <button data-toggle="modal" data-target="#myModal'.$listEvent[$i]["id"].'" href="#infos" class="btn btn-danger form-control col-lg-3">Supprimer l\'évènement</button>
          <div class="col-lg-4">
<div class="modal fade" id="myModal'.$listEvent[$i]["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h4 class="modal-title">Avertissement</h4>
      </div>
      <div class="modal-body">
        Attention vous vous appretez a supprimer l\'évènement "'.$listEvent[$i]["nom_event"].'", cette action est irreversible etes-vous sur de vouloir continuer ?
      </div>
      <div class="modal-footer">
        <a href="?href=mod_evenement&action=suppr&data='.$listEvent[$i]["id"].'"><button class="btn btn-danger">Supprimer definitivement</button></a>
        <button class="btn btn-primary" data-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>
          </div>
          </div>';
		  $i++;
	} ?>
</div>
<script>
<?php

	$i = 0;
	while ($i < $nbEvent)
	{
		echo "$('#evenement_".$listEvent[$i]['id']."').hide();";
		echo "$('#btn_evenement_".$listEvent[$i]['id']."').click(function()  {
				showEvenement('#evenement_".$listEvent[$i]['id']."');
														});";
		$i++;
	}
	$i = 0;
	echo "function showEvenement(evenement_id) {";
	while ($i < $nbEvent)
	{
		echo "$('#evenement_".$listEvent[$i]['id']."').slideUp();";
		$i++;
	}
			echo "$(evenement_id).slideDown();}";?>
function changeLieu($id) {
var allOpt = document.getElementById('select_salle').getElementsByTagName('option');
for (var i = 0; i < allOpt.length; i++)
{	
	console.log(allOpt[i].getAttribute('data-lieu'));
	if (allOpt[i].getAttribute('data-lieu') == $id || allOpt[i].getAttribute('data-lieu') == null)
		allOpt[i].setAttribute('style', "display: block;");
	else
		allOpt[i].setAttribute('style', "display: none;");
	document.getElementById('select_salle').value = 0;

}
};
</script>

