<?php

	$DB_DSN = "mysql:host=localhost";
	$DB_USER = "root";
	$DB_PASSWORD = "Leg0las";
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$database = "`gestionevent`";
?>