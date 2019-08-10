<?php
	include_once 'conexao.php';
	include_once('auth.php');
	
	$auth_usr = $_POST['auth-usr'];
	$auth_psw = $_POST['auth-psw'];
	
	auth($auth_usr,$auth_psw);
	
	$medicao_id = $_POST['medicao-id'];
	$carteira = $_POST['carteira'];
	$conta_index = $_POST['conta_index'];

	$sql1 = $dbcon -> query("UPDATE `medicoes` SET `boleto-gerado` = 1, `data-boleto-gerado` = now(), `carteira-selecionada` = '$carteira', `conta-selecionada-index` = $conta_index WHERE `id` = $medicao_id");

	if($dbcon->affected_rows > 0){
		$jsonString = "ok;";
	    
        $jsonString .= "[";

        while($dados = $sql1->fetch_array()){
            $jsonString .= "{";

            $jsonString .= "\"id\":\"";
            $jsonString .= $dados['id'];
            $jsonString .= "\",";
            
            $jsonString .= "\"cpf\":\"";
            $jsonString .= $dados['cpf'];
            $jsonString .= "\",";
            
            $jsonString .= "\"nome\":\"";
            $jsonString .= $dados['nome'];
            $jsonString .= "\",";
            
            $jsonString .= "\"senha\":\"";
            $jsonString .= $dados['senha'];
            $jsonString .= "\"";

            $jsonString .= "},"; //fechando obj total
        }
        
        $jsonString = rtrim($jsonString, ',');

        $jsonString .= "]";
        
        echo $jsonString;
	}else{
		echo "erro";
  	}
?>