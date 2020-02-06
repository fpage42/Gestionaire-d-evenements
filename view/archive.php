<?php

$dateDebut = null;
$dateFin = null;
$type = null;
$salle = null;
$lieu = null;

if ($_GET['dateDebut'] == null)
{
	$dateDebut = '2000-01-01';
}
else
	$dateDebut = $_GET['dateDebut'];
if ($_GET['dateFin'] == null)
	$dateFin = '2500-01-01';
else
	$dateFin = $_GET['dateFin'];
$type = $_GET['type'];
$lieu = $_GET['lieu'];
$data = getArchive($dateDebut, $dateFin, $_GET['type'], $_GET['lieu'], $_GET['salle'], $_GET['age']);

$evenementEcrit = 0;
$dateEcrit = 0;

?>

<div class="row well">
<table><tr><td>
<label> Statistique :</label><br /></td></tr>
<tr><td><label>Evènement :</label></td><td>
<button class="btn btn-info">Nombre d'évènement <span id="nbev" class="badge"></span></button><br /><br /></td></tr>
<tr><td><label>Inscrit :</label></td><td>
<button class="btn btn-info">Nombre d'inscrit <span id="insc" class="badge"></span></button>
<button class="btn btn-info">Nombre de personne presentes <span id="npp" class="badge"></span></button>
<button class="btn btn-info">Nom qui n'apparait qu'une fois <span id="nu" class="badge"></span></button>
<button class="btn btn-info">Nombre de personne <span id="np" class="badge"></span></button></td></tr>
</table>
</div>

<?php
echo '<div class="row">
          <div class="col-lg-2">
		  <ul id="liste_event_actif" class="list-unstyled">';
foreach ($data as $elem)
{
		$timestampEvent = mktime(substr($elem["timestamp"], 11, 2),
						 	 substr($elem["timestamp"], 14, 2),
							 substr($elem["timestamp"], 17, 2),
							 substr($elem["timestamp"], 5, 2),
							 substr($elem["timestamp"], 8, 2),
							 substr($elem["timestamp"], 0, 4));
	if ($dateEcrit < $timestampEvent / 86400)
	{
		echo '<li><b>'.$jour[date("w", $timestampEvent)]." ".date("d", $timestampEvent)." ".$mois[date("n", $timestampEvent)]." ".date("Y", $timestampEvent).'</b></li>';
		$dateEcrit = $timestampEvent / 86400;
	}
	if ($timestampEvent / 86400 <= $dateEcrit)
	{
			echo "<li><a id='btn_evenement_".$elem["id"]."' href=#>".$elem["nom_event"]."</a></li>";

		$evenementEcrit++;
	}
}
echo '</ul>
</div>';
foreach ($data as $elem)
	formatEvenement($elem);
?>

<script>
<?php

foreach ( $data as $elem)
{
		echo "$('#evenement_".$elem['id']."').hide();";
		echo "$('#btn_evenement_".$elem['id']."').click(function()  {
				showEvenement('#evenement_".$elem['id']."');
														});";
}
echo "function showEvenement(evenement_id) {";
foreach ( $data as $elem)
{
	echo "$('#evenement_".$elem['id']."').slideUp();";
}
	echo "$(evenement_id).slideDown();}";
	?>
	
$(window).load(function(){
	var nom = $(".tab_nom");
	var prenom = $(".tab_prenom");
	$("#insc").text(nom.length);
	$("#nbev").text(<?php echo count($data); ?>);
	
	var cnu = 0;
	var cnpp = 0;
	var cnp = 0;
	var id = 0;
	while (id < nom.length)
	{
		var i = 0;
		var checkNomUnique = false;
		var checkNombrePersonne = false;
		var checkNombrePersonnePresent = false;
		while (i < nom.length)
		{
			if (i != id && nom[i].innerText == nom[id].innerText && prenom[i].innerText == prenom[id].innerText)
			{
				checkNomUnique = true;
				if (i < id)
				{
					checkNombrePersonne = true;
				}
			}
				i++;
		}
		if (!checkNomUnique)
			cnu++;
		if (!checkNombrePersonne)
			cnp++;
		if (!nom[id].parentNode.classList.contains('danger'))
			cnpp++;
		
		id++;
	}
	$('#nu').text(cnu);
	$('#np').text(cnp);
	$('#npp').text(cnpp);
});
</script>
