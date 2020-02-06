<div class="modal" id="infos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h4 class="modal-title">Avertissement</h4>
      </div>
      <div class="modal-body">
        Cette action vous permet d'envoyer un mail d'essais afin de visualiser son contenu.
      </div>
      <div class="modal-footer">
		<form method="post" action="?href=config_mail&action=testMail">
		<input name="data" type="text" class="form-control" placeholder="Adresse email d'essais"><br />
        <input class="btn btn-primary" type="submit" value="Envoyer">
		</form>
		</div>
    </div>
  </div>
</div>
<div class="row">
<span class="col-lg-offset-9 col-lg-2">
<?php
if (isMailActive())
	echo "<a href=?href=config_mail&action=toggleActive><button class='btn btn-info'>Desactiver l'envois de mail automatique</button></a>";
else
	echo "<a href=?href=config_mail&action=toggleActive><button class='btn btn-info'>Activer l'envois de mail automatique</button></a>";
fgets($file);
?>
</span>
</div>
<div class="row well">
<form method='post' action='?href=config_mail&action=registerMail'>
    <div class="form-group">
        <label>Nom de l'expediteur:</label>
        <input name="nom" type="text" class="form-control" value="<?php echo fgets($file); ?>">
    </div>
    <div class="form-group">
        <label>Expediteur:</label>
        <input name="expediteur" type="text" class="form-control" value="<?php echo fgets($file); ?>">
    </div>
        <div class="form-group">
        <label>Objet:</label>
        <input name="objet" type="text" class="form-control" value="<?php echo fgets($file); ?>">
    </div>
    <div class="form-group">
        <label>Contenu de l'email:</label>
        <textarea name="content" class="form-control" rows="10"><?php
		while (($text = fgets($file)))
				echo $text;?></textarea>
    </div>
    <input type="submit" class="btn btn-primary col-lg-2" rows="10">
</form>
          <button data-toggle="modal" href="#infos" class="btn btn-warning col-lg-offset-6 col-lg-4">Envoyer un email d'essais (adresse configurable)</button>


<div class="row">
        <div class="col-lg-6">
        Possibilite d'inserer les balises:<br />
        [nom_utilisateur]: insert le nom de l'utilisateur<br />
        [prenom_utilisateur]: insert le prenom de l'utilisateur<br />
        [age_utilisateur]: insert l'age de l'utilisateur<br />
        [evenement]: insert le nom de l'évènement<br />
        [date]: insert la date de l'évènement<br />
        [heure]: insert l'heure de l'évènement<br />
        [lieu]: insert le lieu de l'évènement<br />
        [salle]: insert la salle de l'évènement<br />
		[telephone]: insert le numero de téléphone du lieu de l'évènement
        </div>
<div class="col-lg-6">
<h4>Exemple:</h4><label>Le mail: </label><br />
Bonjour [prenom_utilisateur] [nom_utilisateur], vous etes inscrit a l'évènement: [evenement] qui aura lieu le: [date].<br />
<label>Donnera:</label><br />
Bonjour Jean Dupont, vous etes inscrit a l'évènement: atelier numerique: decouverte de l'ordinateur qui aura lieu le: 06 juin 2016.
</div>
</div>
</div>