<?php

$path = '/var/www/html/evenement/';

$root['controller']['type'] = $path."controller/type.php";
$root['controller']['index'] = $path."controller/principale.php";
$root['controller']['crea_evenement'] = $path."controller/crea_evenement.php";
$root['controller']['mod_evenement'] = $path."controller/mod_evenement.php";
$root['controller']['lieu'] = $path."controller/lieu.php";
$root['controller']['salle'] = $path."controller/salle.php";
$root['controller']['archivage'] = $path."controller/archivage.php";
$root['controller']['archive'] = $path."controller/archive.php";
$root['controller']['config_mail'] = $path."controller/config_mail.php";
$root['controller']['connect'] = $path."controller/connect.php";
$root['controller']['resetPass'] = $path."controller/resetPass.php";
$root['controller']['mail'] = $path."controller/mail.php";
$root['controller']['logout'] = $path."logout.php";

$root['view']['type'] = $path."view/type.php";
$root['view']['crea_evenement'] = $path."view/crea_evenement.php";
$root['view']['index'] = $path."view/principale.php";
$root['view']['config_mail'] = $path."view/config_mail.php";
$root['view']['lieu'] = $path."view/lieu.php";
$root['view']['salle'] = $path."view/salle.php";
$root['view']['mod_evenement'] = $path."view/mod_evenement.php";
$root['view']['archivage'] = $path."view/archivage.php";
$root['view']['archive'] = $path."view/archive.php";
$root['view']['selectArchive'] = $path."view/selectArchive.php";
$root['view']['password'] = $path."include/protectPassword.php";

$root['model']['type'] = $path."model/type.php";
$root['model']['evenement'] = $path."model/evenement.php";
$root['model']['inscrit'] = $path."model/inscrit.php";
$root['model']['lieu'] = $path."model/lieu.php";
$root['model']['salle'] = $path."model/salle.php";
$root['model']['archive_evenement'] = $path."model/archive_evenement.php";
$root['model']['archive_inscrit'] = $path."model/archive_inscrit.php";
$root['model']['mail'] = $path."model/mail.php";

$root['include']['password'] = $path."include/protectPassword.php";

$file=fopen($path.'data/password', 'r+');
$pass = fgets($file);
$config['pass'] = $pass;
fclose($file);
?>