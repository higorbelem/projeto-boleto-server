<?php
    include_once 'conexao.php';

    $data = json_decode(file_get_contents('php://input'), TRUE);
    $cpf = $data['cpf'];
    $senha = $data['senha'];
    
    $sql1 = $dbcon -> query("SELECT * FROM `medidor` WHERE `cpf` = $cpf AND `senha` = $senha");

	if(mysqli_num_rows($sql1) > 0){
	    $dados = $sql1->fetch_array();
	    
        echo "{";
        
        echo "\"id\":\"";
		echo $dados['id'];
		echo "\",";
		
		echo "\"cpf\":\"";
		echo $dados['cpf'];
		echo "\",";
		
		echo "\"cedenteId\":\"";
		echo $dados['cedente-id'];
		echo "\",";
		
		echo "\"nome\":\"";
		echo $dados['nome'];
		echo "\"";
	
	    echo "}";
	}else{
	    echo "erro-login";
    }

?>

