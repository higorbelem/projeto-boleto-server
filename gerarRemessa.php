<?php
	include_once 'conexao.php';
	
	$arquivo_remessa = $_POST['arquivo-remessa'];
	$id_boletos = $_POST['id-boletos'];

	$sql1 = $dbcon -> query("INSERT INTO `remessa` (`data`,`arquivo-remessa`,`arquivo-retorno`,`enviado`) VALUES (NOW(), '$arquivo_remessa', '', 0)");

	if($sql1){
		  
		$remessa_id = $dbcon->insert_id;
		$mysql_query = "INSERT INTO `medicoes-remessa` (`medicoes-id`,`remessa-id`) VALUES ";

		$lastElement = end($id_boletos);
		foreach ($id_boletos as $value) {
			if($value == $lastElement) {
				$mysql_query .= "(" . $value . "," . $remessa_id . ")";
			}else{
				$mysql_query .= "(" . $value . "," . $remessa_id . "),";
			}
		}

		//echo $mysql_query;
		$sql2 = $dbcon -> query($mysql_query);

		if($sql1){
			echo "ok";
		}else{
			echo "erro";
		}
	}else{
		echo "erro";
  	}
?>