<?php

include_once('../include/mysql.php');

	if (isset($_GET['id']))
	{
		$req = $db->prepare('SELECT * FROM '.$database.'.`lieu` WHERE id=:id');
		$req->execute(array(':id' => $_GET['id']));
		$res = $req->fetchAll();
		echo json_encode($res);
	}
?>