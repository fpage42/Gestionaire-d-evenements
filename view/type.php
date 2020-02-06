<div class="row">
<form id='formulaire' class="well col-lg-offset-3 col-lg-6 col-lg-offset-3" method='post'
	  action='?href=type&action=crea_type'>
    <div class="form-group">
        <label>Nom du type d'évènement:</label>
        <input id="form-name" name="name_type" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label>Nom de l'évènement:</label>
        <input id="form-event" name='name_event' type="text" class="form-control">
    </div>
    <div class="form-group">
        <label>Déscription de l'évènement:</label>
        <textarea id="form-desc" name="description" class="form-control" rows="4"></textarea>
    </div>
    <div class="form-group">
        <label>Lieu:</label>
        <select value='0' id="select_lieu" name="lieu" class="form-control" onChange="changeLieu(document.getElementById('select_lieu').value);">
		<?php
		$allLieu = getAllLieu();
		foreach ($allLieu as $value)
			echo '<option value='.$value["id"].'>'.$value["nom"].'</option>';
		?>
        </select>
    </div>
    <div class="form-group">
        <label>Salle de l'évènement:</label>
		<select id="select_salle" name="salle" class="form-control">
		<?php
		$allSalle = getAllSalle();
		foreach ($allSalle as $value)
		{
			if ($value["id_lieu"] != null)
				echo '<option data-lieu='.$value["id_lieu"].' value='.$value["id"].'>'.$value["nom"].'</option>';
			else
				echo '<option value='.$value["id"].'>'.$value["nom"].'</option>';
				
		}
		?>
        </select>
    </div>
    <div class="form-group">
        <label>Nombres de places:</label>
        <input id="form-place" name="nb_place" type="number" class="form-control">
    </div>
	    <div class="form-group">
        <span title="1 mois = 30 jours"><label>Dévérouillage de l'évènement:<span class="glyphicon glyphicon glyphicon-pushpin"></span></label></span>
	<div class="input-group">
        <input id="form-month" name="deve_month" type="number" class="form-control" value="0">
        <span class="input-group-addon">mois</span>
        <input id="form-day" name="deve_day" type="number" class="form-control" value="15">
        <span class="input-group-addon">jours</span>
	</div></div>
	<table class="form-group">
		<tr><td colspan=2><label>Tranche d'âge&nbsp;&nbsp;&nbsp;</label></td></tr>
		<tr><td><label>0-3 ans&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-age-03" name="0-3" type="checkbox" data-switch-no-init></td></tr>
		<tr><td><label>3-6 ans&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-age-36" name="3-6" type="checkbox" data-switch-no-init></td></tr>
		<tr><td><label>6-12 ans&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-age-612" name="6-12" type="checkbox" data-switch-no-init></td></tr>
		<tr><td><label>12 ans et plus&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-age-12" name="12+" type="checkbox" data-switch-no-init></td></tr>
		<tr><td><label>Adultes&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-age-adulte" name="adulte" type="checkbox" data-switch-no-init></td></tr>
	</table>
        <input id="btn-form" type="submit" value="Valider" class="btn btn-primary form-control">
</form>


<div class="row col-lg-offset-1 col-lg-10">
	<table class="table">
	<?php $allType = getAllType();
		foreach ($allType as $value){
			if ($value['id'] != 0)
			echo '<tr><td>'.$value["nom_type"].'</td><td><a href="#" data='.$value["id"].'" onClick="clickModif('.$value['id'].')"><span class="glyphicon glyphicon-pencil"></span></a><a href="?href=type&action=suppr&data='.$value["id"].'"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';
}
	?>
	</table>
</div>

<script>

function clickModif(id)
{
		var requete = null;
		if (window.XMLHttpRequest) requete = new XMLHttpRequest();
		else if (window.ActiveXObject) requete = new ActiveXObject("Microsoft.XMLHTTP");
		else return;
		requete.open('GET', '/evenement/data/jsonType.php?id='+id, false);
		requete.send(null);
		var type = jQuery.parseJSON(requete.responseText);
	$('#btn-form').val("Modifier");
	$('#formulaire').attr("action", "?href=type&action=modif&data=" + id);
	$('#form-name').attr("readonly", true);
	$('#form-name').val(type[0]['nom_type']);
	$('#form-event').val(type[0]['nom_event']);
	$('#form-desc').val(type[0]['description']);
	$('#select_lieu').val(type[0]['id_lieu']);
	changeLieu(type[0]['id_lieu']);
	$('#select_salle').val(type[0]['id_salle']);
	if (type[0]['nb_place'] != "0")
		$('#form-place').val(type[0]['nb_place']);
	else
		$('#form-place').val("0");
	console.log(type);
	if (type[0]['deve_month'] != "0")
		$('#form-month').val(type[0]['deve_month']);
	else
		$('#form-mounth').val("0");
	if (type[0]['deve_day'] != "0")
		$('#form-day').val(type[0]['deve_day']);
	else
		$('#form-day').val("0");

	if (type[0]['03'] == "1")
		$('#form-age-03').prop('checked', true);
	else
		$('#form-age-03').prop('checked', false);
	if (type[0]['36'] == "1")
		$('#form-age-36').prop('checked', true);
	else
		$('#form-age-36').prop('checked', false);
	if (type[0]['612'] == "1")
		$('#form-age-612').prop('checked', true);
	else
		$('#form-age-612').prop('checked', false);
	if (type[0]['12'] == "1")
		$('#form-age-12').prop('checked', true);
	else
		$('#form-age-12').prop('checked', false);
	if (type[0]['adulte'] == "1")
		$('#form-age-adulte').prop('checked', true);
	else
		$('#form-age-adulte').prop('checked', false);
}

function changeLieu($id) {
console.log('call');
var allOpt = document.getElementById('select_salle').getElementsByTagName('option');
for (var i = 0; i < allOpt.length; i++)
{	
	if (allOpt[i].getAttribute('data-lieu') == $id || allOpt[i].getAttribute('data-lieu') == null)
		allOpt[i].setAttribute('style', "display: block;");
	else
		allOpt[i].setAttribute('style', "display: none;");
	document.getElementById('select_salle').value = 0;

}
};
</script>