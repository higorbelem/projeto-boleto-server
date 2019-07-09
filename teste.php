<?php

	include_once('auth.php');
	
	$auth_usr = $_GET['auth-usr'];
	$auth_psw = $_GET['auth-psw'];
	
	echo '1 ';
	
	auth($auth_usr,$auth_psw);
	
	echo '2';
	
?>