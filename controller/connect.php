<?php

if (isset($_POST['password']) && $_POST['password'] == $config['pass'])
{
	$_SESSION['pass'] = $_POST['password'];
	header("location: ?href=".$_GET['href_a']."&password=ok");
}
else
	header("location: ?href=".$_GET['href_a']."&password=err");	
?>