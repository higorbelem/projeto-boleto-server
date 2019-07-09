<?php
	include_once 'conexao.php';
	include_once ('auth.php');
	
	$auth_usr = $_POST['auth-usr'];
	$auth_psw = $_POST['auth-psw'];
	
	auth($auth_usr,$auth_psw);
    
    $id_remessa = $_POST['id-remessa'];
	$enviada = $_POST['enviada'];

	$sql1 = $dbcon -> query("UPDATE `remessa` SET `enviado` = $enviada, `data-envio` = now() WHERE `id` = $id_remessa");

	if($sql1){
      	echo "ok";
	}else{
		echo "erro";
  	}
?>