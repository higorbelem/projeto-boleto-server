<?php
	include_once 'conexao.php';
	include_once('auth.php');
	
	$auth_usr = $_POST['auth-usr'];
	$auth_psw = $_POST['auth-psw'];
	
	auth($auth_usr,$auth_psw);
	
	$casa_id = $_POST['casa-id'];
	$data_medicao = $_POST['data-medicao'];

	$sql1 = $dbcon -> query("SELECT * FROM medicoes WHERE `casa-id` = $casa_id AND `data-medicao` < '$data_medicao'ORDER BY `data-medicao` DESC");

	if(mysqli_num_rows($sql1) > 0){
        echo "ok;";

        echo "[";
        while($dados = $sql1->fetch_array()){
            echo "{";

            echo "\"id\":\"";
            echo $dados['id'];
            echo "\",";
            
            echo "\"dataMedicao\":\"";
            echo $dados['data-medicao'];
            echo "\",";
            
            echo "\"boletoGerado\":\"";
            echo $dados['boleto-gerado'];
            echo "\",";
            
            echo "\"medicao\":\"";
            echo $dados['medicao'];
            echo "\",";

            echo "\"dataBoletoGerado\":\"";
            echo $dados['data-boleto-gerado'];
            echo "\",";

            echo "\"carteiraSelecionada\":\"";
            echo $dados['carteira-selecionada'];
            echo "\",";

            echo "\"contaSelecionadaIndex\":\"";
            echo $dados['conta-selecionada-index'];
            echo "\"";

            echo "},";
        }

        echo "]";
	}else{
		echo "erro";
  	}
?>