<?php
	include_once 'conexao.php';
    
    $id_remessa = $_POST['id-remessa'];
	$enviada = $_POST['enviada'];

	$sql1 = $dbcon -> query("UPDATE `remessa` SET `enviado` = $enviada, `data-envio` = now() WHERE `id` = $id_remessa");

	if($sql1){
      	echo "ok";
	}else{
		echo "erro";
  	}
?>