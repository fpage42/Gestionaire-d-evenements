<div class="row well">
	<form class="form-inline">
	<span>
		<label>Lieu: </label>
		<?php
		$lieu = getAllLieu();
		echo '<select id="tri_lieu" class="form-control" onChange="selectTriLieu()"><option value="-1">Aucun tri</option>';
		foreach ($lieu as $elem)
		{
			echo '<option value="'.$elem['id'].'">'.$elem['nom'].'</option>';
		}
		echo '</select>';
		?>
	</span>
	<span>
		<label>Salle: </label>
		<?php
		$salle = getAllSalle();
		echo '<select id="tri_salle" class="form-control" onChange="selectTriSalle()"><option value="-1">Aucun tri</option>';
		foreach ($salle as $elem)
		{
			echo '<option value="'.$elem['id'].'">'.$elem['nom'].'</option>';
		}
		echo '</select>';
		?>
	</span>
	<span>
		<label>Type d'évènement: </label>
		<?php
		$type = getAllType();
		echo '<select id="tri_type" class="form-control" onChange="selectTriType()"><option value="-1">Aucun tri</option>';
		foreach ($type as $elem)
		{
			echo '<option value="'.$elem['id'].'">'.$elem['nom_type'].'</option>';
		}
		echo '</select>';
		?>
	</span>
	</form>
</div>
<div class="row">
          <div class="col-lg-2" id="listeEvent">
          <ul id="liste_event_actif" class="list-unstyled">
<?php
$listEvent = getAllEvent();

$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$nbEvent = count($listEvent);
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
		echo '<li class="date"><b>'.$jour[date("w", $timestampEvent)]." ".date("d", $timestampEvent)." ".$mois[date("n", $timestampEvent)]." ".date("Y", $timestampEvent).'</b></li>';
		$dateEcrit = $timestampEvent / 86400;
	}
	if (($timestampEvent - $timestampEvent % 86400) / 86400 <= $dateEcrit)
	{
		$timeUnlock = ($listEvent[$i]["deve_month"] * 30 + $listEvent[$i]["deve_day"]) * 86400;
		if ($timestampEvent < time())
			echo "<li data-lieu='".$listEvent[$i]['id_lieu']."' data-salle='".$listEvent[$i]['id_salle']."' data-type='".$listEvent[$i]['type_id']."'><a style='color:grey; text-decoration: line-through;' id='btn_evenement_".$listEvent[$i]["id"]."' href=#>".$listEvent[$i]["nom_event"]."</a></li>";
			else if ($timestampEvent - $timeUnlock < time())
			echo "<li data-lieu='".$listEvent[$i]['id_lieu']."' data-salle='".$listEvent[$i]['id_salle']."' data-type='".$listEvent[$i]['type_id']."'><a id='btn_evenement_".$listEvent[$i]["id"]."' href=#>".$listEvent[$i]["nom_event"]."</a></li>";
		else
			echo "<li data-lieu='".$listEvent[$i]['id_lieu']."' data-salle='".$listEvent[$i]['id_salle']."' data-type='".$listEvent[$i]['type_id']."'><a style='color:grey;' id='btn_evenement_".$listEvent[$i]["id"]."' href=#>".$listEvent[$i]["nom_event"]."</a></li>";

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
		$listInscrit = getInscrit($listEvent[$i]["id"]);
		$timestampEvent = mktime(substr($listEvent[$i]["timestamp"], 11, 2),
					 	 substr($listEvent[$i]["timestamp"], 14, 2),
						 substr($listEvent[$i]["timestamp"], 17, 2),
						 substr($listEvent[$i]["timestamp"], 5, 2),
						 substr($listEvent[$i]["timestamp"], 8, 2),
						 substr($listEvent[$i]["timestamp"], 0, 4));
		$dateUnlock = $timestampEvent - (($listEvent[$i]["deve_month"] * 30 + $listEvent[$i]["deve_day"]) * 86400);
		echo '<div class="col-lg-10" id="evenement_'.$listEvent[$i]["id"].'">
		<div style="color:black; font-size: 120%" class="alert span5 alert-success">'.$listEvent[$i]["description"].'<br /><br /><table>
		<tr><td>Date</td><td> &nbsp;&nbsp;&nbsp;'.$jour[date("w", $timestampEvent)]." ".date("d", $timestampEvent)." ".$mois[date("n", $timestampEvent)]." ".date("Y", $timestampEvent).' à '.substr($listEvent[$i]["timestamp"], 11, 5).'
		<tr><td>Date de debut d\'inscription</td><td> &nbsp;&nbsp;&nbsp;'.$jour[date("w", $dateUnlock)]." ".date("d", $dateUnlock)." ".$mois[date("n", $dateUnlock)]." ".date("Y", $dateUnlock).'
		</td></tr><tr><td>Lieu </td><td>&nbsp;&nbsp;&nbsp;';
		$lieu = getLieuById($listEvent[$i]['id_lieu']);
		echo $lieu['nom'];
		$salle = getSalleById($listEvent[$i]['id_salle']);
		echo '</td></tr><tr><td>Salle </td><td>&nbsp;&nbsp;&nbsp;'.$salle['nom'];
		echo '</td></tr><tr><td>Nombre de places disponibles</td><td>&nbsp;&nbsp;&nbsp;'.count($listInscrit).'/'.$listEvent[$i]["nb_place"].'</td></tr>';
		echo '</td></tr></table>
		</div>
		<table class="table">
		<tr class="active"><td><strong>Nom<span style="color:red">*</span></strong></td><td><strong>Prénom<span style="color:red">*</span></strong></td><td><strong>Email</strong></td><td><strong>Téléphone</strong></td><td><strong>Age</strong></td><td><strong>Mois</strong></td><td><strong>Commentaire</strong></td><td><strong>Gestion</strong></td></tr>
		<tr>
		<form method="post" action="?href=index&action=inscrit&data='.$listEvent[$i]["id"].'">';
		$timeUnlock = ($listEvent[$i]["deve_month"] * 30 + $listEvent[$i]["deve_day"]) * 86400;
		$disabled = false;
		if ($listEvent[$i]['nb_place'] <= count($listInscrit))
			$disabled = true;
		else if ($timestampEvent < time())
			$disabled = true;
		else if ($timestampEvent - $timeUnlock < time())
			$disabled = false;
		else
			$disabled = true;		
		if ($disabled)
			echo '<td><input id="nom_'.$listEvent[$i]["id"].'" name="nom" type="texte" class="form-control" disabled=disabled></td>
		<td><input id="prenom_'.$listEvent[$i]["id"].'" name="prenom" type="texte" class="form-control" disabled=disabled></td>
		<td><input id="email_'.$listEvent[$i]["id"].'" name="email" type="texte" class="form-control" disabled=disabled></td>
		<td><input id="tel_'.$listEvent[$i]["id"].'" name="telephone" type="texte" class="form-control" disabled=disabled></td>
		<td><input id="age_'.$listEvent[$i]["id"].'" name="age" type="number" class="form-control" disabled=disabled></td>
		<td><input id="mois_'.$listEvent[$i]["id"].'" name="mois" type="number" class="form-control" disabled=disabled></td>
		<td><input id="comment_'.$listEvent[$i]["id"].'" name="comment" type="text" class="form-control" disabled=disabled></td>
		<td><input id="submit_'.$listEvent[$i]["id"].'" value="Inscrire" type="submit" class="btn btn-primary" disabled=disabled></td>';
		else
			echo'<td><input id="nom_'.$listEvent[$i]["id"].'" name="nom" type="texte" class="form-control"></td>
		<td><input id="prenom_'.$listEvent[$i]["id"].'" name="prenom" type="texte" class="form-control"></td>
		<td><input id="email'.$listEvent[$i]["id"].'" name="email" type="texte" class="form-control"></td>
		<td><input id="tel_'.$listEvent[$i]["id"].'" name="telephone" type="texte" class="form-control"></td>
		<td><input id="age_'.$listEvent[$i]["id"].'" name="age" type="number" class="form-control"></td>
		<td><input id="mois_'.$listEvent[$i]["id"].'" name="mois" type="number" class="form-control"></td>
		<td><input id="comment_'.$listEvent[$i]["id"].'" name="comment" type="text" class="form-control"></td>
		<td><input id="submit_'.$listEvent[$i]["id"].'" value="Inscrire" type="submit" class="btn btn-primary"></td>';

		echo '</form></tr>';
		foreach ($listInscrit as $elem)
		{
			echo '<tr><td>'.$elem["nom"].'</td><td>'.$elem["prenom"].'</td><td>'.$elem["email"].'</td><td>'.$elem["telephone"].'</td><td>';
			if ($elem["age"] != 0)
				echo $elem["age"];
			echo '</td><td>';
			
			if ($elem["mois"] != 0)
				echo $elem['mois'];
			echo '</td><td>'.$elem['comment'].'</td><td><a href="#" onClick="modifUser('.$listEvent[$i]['id'].', '.$elem['id'].');"><div class="glyphicon glyphicon-pencil"></div></a>';
			if ($timestampEvent < time())
				echo '</td></tr>';
			else
				echo '&nbsp;&nbsp;&nbsp;<a href="?href=index&action=suppr_user&data='.$listEvent[$i]['id'].'&user='.$elem["id"].'"><div class="glyphicon glyphicon-remove"></div></a></td></tr>';
		}
		echo '</table></div>';
		$i++;
	}
	?>

	<div class="modal" id="modalActualise" data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Avertissement</h4>
		  </div>
		  <div class="modal-body">
			Votre page est ouverte depuis plus de cinq minutes, il se peut qu'il y ait des changements. Merci d'actualiser !
		  </div>
		<div class="modal-footer">
			<button class="btn btn-info" onClick="window.location = refresh">Actualiser</button>
			</div>
		</div>
	  </div>
	</div>

</div>

<script>

var refresh = "?href=index";
var lieu_tri = -1;
var salle_tri = -1;
var type_tri = -1;
<?php

	$i = 0;
	while ($i < $nbEvent)
	{
		echo "$('#evenement_".$listEvent[$i]['id']."').hide();";
		echo "$('#btn_evenement_".$listEvent[$i]['id']."').click(function()  {
				showEvenement('#evenement_".$listEvent[$i]['id']."');});";
		$i++;
	}
	$i = 0;
	echo "function showEvenement(evenement_id) {";
	while ($i < $nbEvent)
	{
		echo "$('#evenement_".$listEvent[$i]['id']."').slideUp();";
		$i++;
	}
			echo "$(evenement_id).slideDown();
			refresh = '?href=index&event=' + evenement_id;
			}";
			
	?>
	
	function modifUser(idEvent, idUser)
	{
		var requete = null;
		if (window.XMLHttpRequest) requete = new XMLHttpRequest();
		else if (window.ActiveXObject) requete = new ActiveXObject("Microsoft.XMLHTTP");
		else return;
		requete.open('GET', '/evenement/data/jsonInscrit.php?id='+idEvent, false);
		requete.send(null);
		var inscrit = jQuery.parseJSON(requete.responseText);
		for (var i = 0; i < inscrit.length; i++)
			if (inscrit[i]["id"] == idUser)
			{
				break;
			}
		$('input#nom_' + idEvent, $('#evenement_' + idEvent)).attr('value', inscrit[i]['nom']);
		$('input#nom_' + idEvent, $('#evenement_' + idEvent)).removeAttr('disabled');
		$('input#prenom_' + idEvent, $('#evenement_' + idEvent)).attr('value', inscrit[i]['prenom']);
		$('input#prenom_' + idEvent, $('#evenement_' + idEvent)).removeAttr('disabled');
		$('input#email_' + idEvent, $('#evenement_' + idEvent)).attr('value', inscrit[i]['email']);
		$('input#email_' + idEvent, $('#evenement_' + idEvent)).removeAttr('disabled');
		$('input#tel_' + idEvent, $('#evenement_' + idEvent)).attr('value', inscrit[i]['telephone']);
		$('input#tel_' + idEvent, $('#evenement_' + idEvent)).removeAttr('disabled');
		if (inscrit[i]['age'] != 0)
			$('input#age_' + idEvent, $('#evenement_' + idEvent)).attr('value', inscrit[i]['age']);
		else
			$('input#age_' + idEvent, $('#evenement_' + idEvent)).attr('value', null);
		$('input#age_' + idEvent, $('#evenement_' + idEvent)).removeAttr('disabled');
		if (inscrit[i]['mois'] != 0)
			$('input#mois_' + idEvent, $('#evenement_' + idEvent)).attr('value', inscrit[i]['mois']);
		else
			$('input#mois_' + idEvent, $('#evenement_' + idEvent)).attr('value', null);
		$('input#mois_' + idEvent, $('#evenement_' + idEvent)).removeAttr('disabled');
		$('input#comment_' + idEvent, $('#evenement_' + idEvent)).attr('value', inscrit[i]['comment']);
		$('input#comment_' + idEvent, $('#evenement_' + idEvent)).removeAttr('disabled');
		$('input#submit_' + idEvent, $('#evenement_' + idEvent)).attr('value', "Modifier");
		$('input#submit_' + idEvent, $('#evenement_' + idEvent)).removeAttr('disabled');
		$('form', $('#evenement_' + idEvent)).attr('action', '?href=index&action=modif&data=' + idEvent + '&user=' + idUser);
	}
	
	function selectTriLieu() {
		lieu_tri = $('#tri_lieu').val();
		sortAll();
	}
	
	function selectTriSalle() {
		salle_tri = $('#tri_salle').val();
		sortAll();
	}
	
	function selectTriType() {
		type_tri = $('#tri_type').val();
		sortAll();
	}
	
	function sortAll() {
		var tabListEvent = $('#liste_event_actif').children();
		for (var i = 0; i < tabListEvent.length; i++)
		{
			if (tabListEvent[i].classList.contains('date'))
				tabListEvent[i].style.display = "block";
			else
			{
			if ((lieu_tri == '-1' || lieu_tri == tabListEvent[i].dataset.lieu) && 
			(salle_tri == tabListEvent[i].dataset.salle || salle_tri == '-1') && 
			(type_tri == '-1' || type_tri == tabListEvent[i].dataset.type))
				tabListEvent[i].style.display = "block";
			else
				tabListEvent[i].style.display = "none";
						
			}
		}
	}
<?php	if (isset($_GET['event']))
			echo "showEvenement('#evenement_".$_GET['event']."');";
	?>
	
setTimeout(function () {
	$("#modalActualise").modal("show");
}, 300000);
</script>

