<?php
	include_once 'conexao.php';
	include_once('auth.php');
	
	$auth_usr = $_POST['auth-usr'];
	$auth_psw = $_POST['auth-psw'];
	
	auth($auth_usr,$auth_psw);
    
    $id_casa = $_POST['id-casa'];    

	$sql1 = $dbcon -> query("UPDATE `casas` SET `excluido` = 1 WHERE `id` = $id_casa");

	if(mysqli_num_rows($sql1) > 0){
        echo "ok";
	}else{
		echo "erro";
   }
?>