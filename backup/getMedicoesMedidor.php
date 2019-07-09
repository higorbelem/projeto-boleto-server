<?php
	include_once 'conexao.php';
	
	$data = json_decode(file_get_contents('php://input'), TRUE);
    $medidor_id = $data['medidor-id'];
    //$medidor_id = $_GET['medidor-id'];

	$sql1 = $dbcon -> query("SELECT me.`id` as 'id-medicoes', me.`data-medicao`, me.`boleto-gerado`, me.`data-boleto-gerado`, me.`medicao`, me.`medicao-anterior`, me.`carteira-selecionada`, me.`conta-selecionada-index`, medidor.`id` as 'id-medidor', medidor.`nome` as 'nome-medidor', medidor.`cpf`, sa.`id` as 'id-sacado', sa.`nome` as 'nome-sacado', sa.`email`, sa.`documento`, sa.`avalista`, sa.`avalista-documento`, ca.`id` as 'id-casa', ca.`bairro`, ca.`cidade`, ca.`dia-vencimento`, ca.`cidade`, ca.`referencia`, ca.`num-hidrometro`, ca.`numero`, ca.`rua`, ca.`UF`, ca.`cep` FROM `medicoes` me INNER JOIN `medidor` ON me.`medidor-id` = medidor.`id` AND medidor.`id` = $medidor_id AND me.`data-medicao` BETWEEN CONVERT_TZ(NOW(),@@global.time_zone,'-03:00') - INTERVAL 30 DAY AND CONVERT_TZ(NOW(),@@global.time_zone,'-03:00') INNER JOIN `casas` ca ON me.`casa-id` = ca.`id` AND ca.`excluido` = 0 INNER JOIN `sacado` sa ON ca.`sacado-id` = sa.`id` ORDER BY me.`data-medicao` DESC");

	if(mysqli_num_rows($sql1) > 0){
	    
	    $jsonString = "";
	    
        $jsonString .= "[";

        while($dados = $sql1->fetch_array()){
            $jsonString .= "{";

            $jsonString .= "\"id\":\"";
            $jsonString .= $dados['id-medicoes'];
            $jsonString .= "\",";
            
            $jsonString .= "\"dataMedicao\":\"";
            $jsonString .= $dados['data-medicao'];
            $jsonString .= "\",";
            
            $jsonString .= "\"boletoGerado\":\"";
            $jsonString .= $dados['boleto-gerado'];
            $jsonString .= "\",";
            
            $jsonString .= "\"medicao\":\"";
            $jsonString .= $dados['medicao'];
            $jsonString .= "\",";

            $jsonString .= "\"medicaoAnterior\":\"";
            $jsonString .= $dados['medicao-anterior'];
            $jsonString .= "\",";

            $jsonString .= "\"dataBoletoGerado\":\"";
            $jsonString .= $dados['data-boleto-gerado'];
            $jsonString .= "\",";

            $jsonString .= "\"carteiraSelecionada\":\"";
            $jsonString .= $dados['carteira-selecionada'];
            $jsonString .= "\",";

            $jsonString .= "\"contaSelecionadaIndex\":\"";
            $jsonString .= $dados['conta-selecionada-index'];
            $jsonString .= "\",";

            $jsonString .= "\"medidor\":{"; // abrindo medidor
            
            $jsonString .= "\"id\":\"";
            $jsonString .= $dados['id-medidor'];
            $jsonString .= "\",";
            
            $jsonString .= "\"nome\":\"";
            $jsonString .= $dados['nome-medidor'];
            $jsonString .= "\",";

            $jsonString .= "\"cpf\":\"";
            $jsonString .= $dados['cpf'];
            $jsonString .= "\"";

            $jsonString .= "},"; //fechando medidor

            $jsonString .= "\"sacado\":{"; // abrindo sacado
            
            $jsonString .= "\"id\":\"";
            $jsonString .= $dados['id-sacado'];
            $jsonString .= "\",";

            $jsonString .= "\"nome\":\"";
            $jsonString .= $dados['nome-sacado'];
            $jsonString .= "\",";

            $jsonString .= "\"email\":\"";
            $jsonString .= $dados['email'];
            $jsonString .= "\",";

            $jsonString .= "\"documento\":\"";
            $jsonString .= $dados['documento'];
            $jsonString .= "\",";

            $jsonString .= "\"avalista\":\"";
            $jsonString .= $dados['avalista'];
            $jsonString .= "\",";

            $jsonString .= "\"avalistaDocumento\":\"";
            $jsonString .= $dados['avalista-documento'];
            $jsonString .= "\"";

            $jsonString .= "},"; //fechando sacado

            $jsonString .= "\"casa\":{"; // abrindo casa
            
            $jsonString .= "\"id\":\"";
            $jsonString .= $dados['id-casa'];
            $jsonString .= "\",";

            $jsonString .= "\"bairro\":\"";
            $jsonString .= $dados['bairro'];
            $jsonString .= "\",";

            $jsonString .= "\"cidade\":\"";
            $jsonString .= $dados['cidade'];
            $jsonString .= "\",";

            $jsonString .= "\"diaVencimento\":\"";
            $jsonString .= $dados['dia-vencimento'];
            $jsonString .= "\",";

            $jsonString .= "\"numHidrometro\":\"";
            $jsonString .= $dados['num-hidrometro'];
            $jsonString .= "\",";

            $jsonString .= "\"numero\":\"";
            $jsonString .= $dados['numero'];
            $jsonString .= "\",";

            $jsonString .= "\"rua\":\"";
            $jsonString .= $dados['rua'];
            $jsonString .= "\",";

            $jsonString .= "\"uf\":\"";
            $jsonString .= $dados['UF'];
            $jsonString .= "\",";

            $jsonString .= "\"cep\":\"";
            $jsonString .= $dados['cep'];
            $jsonString .= "\",";

            $jsonString .= "\"referencia\":\"";
            $jsonString .= $dados['referencia'];
            $jsonString .= "\"";

            $jsonString .= "}"; //fechando casa

            $jsonString .= "},"; //fechando obj total
        }
        
        $jsonString = rtrim($jsonString, ',');

        $jsonString .= "]";
        
        echo $jsonString;
	}else{
		echo "erro";
   }
?>