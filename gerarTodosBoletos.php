<?php
	include_once 'conexao.php';
	
   $cedente_id = $_POST['cedente-id'];
	$carteira = $_POST['carteira'];
	$conta_index = $_POST['conta_index'];

	$sql1 = $dbcon -> query("UPDATE `medicoes` me INNER JOIN `casas` ca ON me.`casa-id` = ca.`id` INNER JOIN `cedentes` ce ON ca.`cedente-id` = ce.`id` SET me.`boleto-gerado` = 1, me.`data-boleto-gerado` = now(), `carteira-selecionada` = $carteira, `conta-selecionada-index` = $conta_index WHERE me.`boleto-gerado` = 0 AND ce.`id` = $cedente_id");

	if($sql1){
      echo "ok";
	}else{
		echo "erro";
   }
?>