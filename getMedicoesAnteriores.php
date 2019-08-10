<?php
	include_once 'conexao.php';
	include_once('auth.php');
	
	$auth_usr = $_POST['auth-usr'];
	$auth_psw = $_POST['auth-psw'];
	
	auth($auth_usr,$auth_psw);
	
	$casa_id = $_POST['casa-id'];
	$data_medicao = $_POST['data-medicao'];

	//$sql1 = $dbcon -> query("SELECT * FROM medicoes WHERE `casa-id` = $casa_id AND `data-medicao` < '$data_medicao'ORDER BY `data-medicao` DESC LIMIT 12");
    $sql1 = $dbcon -> query("SELECT me.`id` as 'id-medicoes', me.`data-medicao`, me.`boleto-gerado`, me.`data-boleto-gerado`, me.`medicao`, me.`medicao-anterior`, me.`data-referencia`, me.`carteira-selecionada`, me.`conta-selecionada-index`, medidor.`id` as 'id-medidor', medidor.`nome` as 'nome-medidor', medidor.`cpf`, sa.`id` as 'id-sacado', sa.`nome` as 'nome-sacado', sa.`email`, sa.`documento`, sa.`avalista`, sa.`avalista-documento`, ca.`id` as 'id-casa', ca.`bairro`, ca.`cidade`, ca.`dia-vencimento`, ca.`cidade`, ca.`referencia`, ca.`num-hidrometro`, ca.`valor-maximo-hidrometro`, ca.`numero`, ca.`rua`, ca.`UF`, ca.`cep` FROM `medicoes` me INNER JOIN `medidor` ON me.`medidor-id` = medidor.`id` AND me.`data-medicao` < '$data_medicao' INNER JOIN `casas` ca ON me.`casa-id` = ca.`id` AND ca.`id` = $casa_id AND ca.`excluido` = 0 INNER JOIN `sacado` sa ON ca.`sacado-id` = sa.`id` ORDER BY `data-medicao` DESC LIMIT 12");

	if(mysqli_num_rows($sql1) > 0){
        echo "ok;";

        echo "[";
        while($dados = $sql1->fetch_array()){
            echo "{";

                echo "\"id\":\"";
                echo $dados['id-medicoes'];
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
       
                echo "\"medicaoAnterior\":\"";
                echo $dados['medicao-anterior'];
                echo "\",";

                echo "\"dataReferencia\":\"";
                echo $dados['data-referencia'];
                echo "\",";
       
                echo "\"dataBoletoGerado\":\"";
                echo $dados['data-boleto-gerado'];
                echo "\",";
       
                echo "\"carteiraSelecionada\":\"";
                echo $dados['carteira-selecionada'];
                echo "\",";
       
                echo "\"contaSelecionadaIndex\":\"";
                echo $dados['conta-selecionada-index'];
                echo "\",";
       
                echo "\"medidor\":{"; // abrindo medidor
                
                echo "\"id\":\"";
                echo $dados['id-medidor'];
                echo "\",";
                
                echo "\"nome\":\"";
                echo $dados['nome-medidor'];
                echo "\",";
       
                echo "\"cpf\":\"";
                echo $dados['cpf'];
                echo "\",";
       
                echo "},"; //fechando medidor
       
                echo "\"sacado\":{"; // abrindo sacado
                
                echo "\"id\":\"";
                echo $dados['id-sacado'];
                echo "\",";
       
                echo "\"nome\":\"";
                echo $dados['nome-sacado'];
                echo "\",";
       
                echo "\"email\":\"";
                echo $dados['email'];
                echo "\",";
       
                echo "\"documento\":\"";
                echo $dados['documento'];
                echo "\",";
       
                echo "\"avalista\":\"";
                echo $dados['avalista'];
                echo "\",";
       
                echo "\"avalistaDocumento\":\"";
                echo $dados['avalista-documento'];
                echo "\",";
       
                echo "},"; //fechando sacado
       
                echo "\"casa\":{"; // abrindo casa
                
                echo "\"id\":\"";
                echo $dados['id-casa'];
                echo "\",";
       
                echo "\"bairro\":\"";
                echo $dados['bairro'];
                echo "\",";
       
                echo "\"cidade\":\"";
                echo $dados['cidade'];
                echo "\",";
       
                echo "\"diaVencimento\":\"";
                echo $dados['dia-vencimento'];
                echo "\",";
       
                echo "\"numHidrometro\":\"";
                echo $dados['num-hidrometro'];
                echo "\",";
       
                echo "\"maxHidrometro\":\"";
                echo $dados['valor-maximo-hidrometro'];
                echo "\",";
       
                echo "\"numero\":\"";
                echo $dados['numero'];
                echo "\",";
       
                echo "\"rua\":\"";
                echo $dados['rua'];
                echo "\",";
       
                echo "\"uf\":\"";
                echo $dados['UF'];
                echo "\",";
       
                echo "\"cep\":\"";
                echo $dados['cep'];
                echo "\",";
       
                echo "\"referencia\":\"";
                echo $dados['referencia'];
                echo "\"";
       
                echo "}"; //fechando casa
       
                echo "},"; //fechando obj total
        }

        echo "]";
	}else{
		echo "erro";
  	}
?>