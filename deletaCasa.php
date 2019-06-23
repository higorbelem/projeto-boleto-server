<?php
	include_once 'conexao.php';
    
    $id_casa = $_POST['id-casa'];    

	$sql1 = $dbcon -> query("UPDATE `casas` SET `excluido` = 1 WHERE `id` = $id_casa");

	if(mysqli_num_rows($sql1) > 0){
        echo "ok";
	}else{
		echo "erro";
   }
?>