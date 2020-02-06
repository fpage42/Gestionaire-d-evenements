<div class="row">
<form method="post" action="?href=crea_evenement&action=crea_event" class="well col-lg-6">
    <div class="form-group">
        <label>Nom de l'évènement:</label>
        <input name="name_event" id="form-name" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label>Déscription de l'évènement: (&lt;b&gt;texte&lt;/b&gt; pour mettre en gras) </label>
        <textarea name="description" id="form-desc" class="form-control" rows="4"></textarea>
    </div>
    <div class="form-group">
        <label>Date:</label>
        <input name="date" type="date" placeholder="jj/mm/aaaa" class="form-control">
    </div>
    <div class="form-group">
        <label>Heure:</label>
        <input name="hour" type="time" placeholder="hh:mm" class="form-control">
	</div>
    <div class="form-group">
        <label>Lieu:</label>
        <select value='0' id="select_lieu" name="lieu" class="form-control" onChange="changeLieu(document.getElementById('select_lieu').value);">
		<?php
		$allLieu = getAllLieu();
		$selectLieu = false;
		foreach ($allLieu as $value)
		{
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
		<select value='0' id="select_salle" name="salle" class="form-control">
		<?php
		$allSalle = getAllSalle();
		$selectSalle = false;
		foreach ($allSalle as $value)
		{
			echo ' <option data-lieu='.$value["id_lieu"].' value='.$value["id"].'>'.$value["nom"].'</option>';
		}
		echo '<option value=0 selected>Autre</option>';
			?>
        </select>
	</div>
    <div class="form-group">
        <label>Nombres de places:</label>
        <input name="nb_place" id="form-place" type="number" class="form-control">
    </div>
    <div class="form-group">
        <span title="Permet de choisir a partir de combien de temps avant le debut de l'évènement l'inscription devient possible"><label>Dévérouillage de l'évènement:<span class="glyphicon glyphicon glyphicon-pushpin"></span></label></span>
	<div class="input-group">
        <input name="deve_month" id="form-deve_month" type="number" class="form-control" value="0">
        <span class="input-group-addon">mois</span>
        <input name="deve_day" id="form-deve_day" type="number" class="form-control" value="15">
        <span class="input-group-addon">jours</span>
	</div>
	</div>
		<table class="form-group">
		<tr><td colspan=2><label>Tranche d'âge&nbsp;&nbsp;&nbsp;</label></td></tr>
		<tr><td><label>0-3 ans&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-03" name="0-3" type="checkbox" data-switch-no-init></td></tr>
		<tr><td><label>3-6 ans&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-36" name="3-6" type="checkbox" data-switch-no-init></td></tr>
		<tr><td><label>6-12 ans&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-612" name="6-12" type="checkbox" data-switch-no-init></td></tr>
		<tr><td><label>12 ans et plus&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-12" name="12+" type="checkbox" data-switch-no-init></td></tr>
		<tr><td><label>Adultes&nbsp;&nbsp;&nbsp;</label></td><td><input id="form-adulte" name="adulte" type="checkbox" data-switch-no-init></td></tr>
	</table>
    <div class="form-group">
        <label>Type d'évènement:</label>
        <input name="type" id="form-type" type="text" class="form-control" readonly="readonly" value="aucun">
    </div>
        <input type="submit" value="Valider" class="btn btn-primary form-control">
</form>
<div class="well col-lg-5 col-lg-offset-1">
	<h4>Séléction d'un type d'évènement:</h4>
<?php
	$allType = getAllType();
		foreach ($allType as $value){
			if ($value['id'] != 0)
				echo '<button onclick="activeType('.$value["id"].')" class="btn btn-primary">'.$value["nom_type"].'</button>';
}
	?>
</div>
</div>


<script>
	function activeType(id)
	{
		var requete = null;
		if (window.XMLHttpRequest) requete = new XMLHttpRequest();
		else if (window.ActiveXObject) requete = new ActiveXObject("Microsoft.XMLHTTP");
		else return;
		requete.open('GET', '/evenement/data/jsonType.php?id='+id, false);
		requete.send(null);
		var type = JSON.parse(requete.responseText);
		document.getElementById("form-name").value = type[0]['nom_event'];
		document.getElementById("form-desc").value = type[0]['description'];
		if (type[0]['id_lieu'] != 0)
			document.getElementById("select_lieu").value = type[0]['id_lieu'];
		else
			document.getElementById("select_lieu").value = "0";
		if (type[0]['id_salle'] != 0)
			document.getElementById("select_salle").value = type[0]['id_salle'];
		else
			document.getElementById("select_salle").value = "0";
		document.getElementById("form-place").value = type[0]['nb_place'];
		document.getElementById("form-deve_month").value = type[0]['deve_month'];
		document.getElementById("form-deve_day").value = type[0]['deve_day'];
		document.getElementById("form-type").value = type[0]['nom_type'];
		if (type[0]['03'] == "1")
			document.getElementById("form-03").checked = "checked";
		if (type[0]['36'] == "1")
			document.getElementById("form-36").checked = "checked";
		if (type[0]['612'] == "1")
			document.getElementById("form-612").checked = "checked";
		if (type[0]['12'] == "1")
			document.getElementById("form-12").checked = "checked";
		if (type[0]['adulte'] == "1")
			document.getElementById("form-adulte").checked = "checked";
	};

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