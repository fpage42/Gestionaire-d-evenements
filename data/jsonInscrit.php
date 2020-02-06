<?php

include_once('../include/mysql.php');

	if (isset($_GET['id']))
	{
		$req = $db->prepare('SELECT * FROM '.$database.'.`inscrit` WHERE id_event=:id');
		$req->execute(array(':id' => $_GET['id']));
		$res = $req->fetchAll();
		echo json_encode($res);
	}
?>