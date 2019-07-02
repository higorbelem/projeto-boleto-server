<?php
	include_once 'conexao.php';
	
	$medicao_id = $_POST['medicao-id'];
	$carteira = $_POST['carteira'];
	$conta_index = $_POST['conta_index'];

	$sql1 = $dbcon -> query("UPDATE `medicoes` SET `boleto-gerado` = 1, `data-boleto-gerado` = now(), `carteira-selecionada` = '$carteira', `conta-selecionada-index` = $conta_index WHERE `id` = $medicao_id");

	if($sql1){
      	echo "ok";
	}else{
		echo "erro";
  	}
?>