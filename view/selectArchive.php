<div class="row well">
<label>Critères de séléctions: </label>
<button class="btn btn-info" onclick="affFormDateDebut();">Date début</button>
<button class="btn btn-info" onclick="affFormDateFin();">Date fin</button>
<button class="btn btn-info" onclick="affFormType();">Type</button>
<button class="btn btn-info" onclick="affFormLieu();">Lieu</button>
<button class="btn btn-info" onclick="affFormSalle();">Salle</button>
<button class="btn btn-info" onclick="affFormAge();">Tranche d'age</button>

</div>




<div class="row">
<div class="col-lg-offset-3 col-lg-6">
<form id="myForm" class="well" action="?href=archive&post=a" method="post">
<input class="btn btn-info" type="submit" value="Afficher les archives">
</form>
</div>
</div>
<script>

var formdd = false;
var formdf = false;
var formt = false;
var forms = false;
var forml = false;
var forma = false;

function affFormDateDebut()
{
	if (!formdd)
	{
		$('#myForm').html($('#myForm').html() + '<div class="form-group"><label>Date début</label><input name=dateDebut class="form-control" type="date"></div>');
		formdd = true;
	}
}

function affFormDateFin()
{
	if (!formdf)
	{
		$('#myForm').html($('#myForm').html() + '<div class="form-group"><label>Date fin</label><input name=dateFin class="form-control" type="date"></div>');
		formdf = true;
	}
}

function affFormType()
{
	if (!formt)
	{
		$('#myForm').html($('#myForm').html() + "<div class='form-group'><label>Type:</label><select name='type' id='form-type' class='form-control'>"		+ <?php $allType = getAllTypeArchive();foreach ($allType as $value)echo '"<option value='.$value["nom"].'>'.$value["nom"].'</option>" + '; ?> "<option value=Autre>Autre</option></select></div>");
		formt = true;
	}
}

function affFormLieu()
{
	if (!forml)
	{
		$('#myForm').html($('#myForm').html() + "<div class='form-group'><label>Lieu:</label><select name='lieu' id='form-lieu' class='form-control'>"		+ <?php $allLieu = getAllLieuArchive();foreach ($allLieu as $value)echo '"<option value='.$value["nom"].'>'.$value["nom"].'</option>" + '; ?> "<option value=Autre>Autre</option></select></div>");
		forml = true;
	}
}

function affFormSalle()
{
	if (!forms)
	{
		$('#myForm').html($('#myForm').html() + "<div class='form-group'><label>Salle:</label><select name='salle' id='form-salle' class='form-control'>"		+ <?php $allSalle = getAllSalleArchive();foreach ($allSalle as $value)echo '"<option value='.$value["nom"].'>'.$value["nom"].'</option>" + '; ?> "<option value=Autre>Autre</option></select></div>");
		forms = true;
	}
}

function affFormAge()
{
	if (!forma)
	{
		$('#myForm').html($('#myForm').html() + "<div class='form-group'><label>Tranche d'age:</label><select name='age' id='form-age' class='form-control'><option value=03>0 à 3 ans</option>'><option value=36>3 à 6 ans</option>'><option value=612>6 à 12 ans</option>'><option value=12+>12 ans et plus</option>'><option value=adulte>Adulte</option></select></div>");
		forma = true;
	}
}

</script>
