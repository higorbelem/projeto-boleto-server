<?php
	include_once 'conexao.php';
	
   $cedente_id = $_POST['cedente-id'];

	$sql1 = $dbcon -> query("SELECT re.`id` as 'id-remessa', re.`data`, re.`arquivo-remessa`, re.`arquivo-retorno`, re.`enviado`, re.`data-envio`, me.`id` as 'id-medicoes', me.`data-medicao`, me.`boleto-gerado`, me.`data-boleto-gerado`, me.`medicao`, me.`medicao-anterior`, me.`carteira-selecionada`, me.`conta-selecionada-index`, medidor.`id` as 'id-medidor', medidor.`nome` as 'nome-medidor', medidor.`cpf`, sa.`id` as 'id-sacado', sa.`nome` as 'nome-sacado', sa.`email`, sa.`documento`, sa.`avalista`, sa.`avalista-documento`, ca.`id` as 'id-casa', ca.`bairro`, ca.`cidade`, ca.`dia-vencimento`, ca.`referencia`, ca.`num-hidrometro`, ca.`numero`, ca.`rua`, ca.`UF`, ca.`cep` FROM `remessa` re INNER JOIN `medicoes-remessa` mere ON mere.`remessa-id` = re.`id` INNER JOIN `medicoes` me ON mere.`medicoes-id` = me.`id` INNER JOIN `medidor` ON me.`medidor-id` = medidor.`id` AND me.`boleto-gerado` = 1  AND 1 = (SELECT COUNT(*) FROM `medicoes-remessa` WHERE `medicoes-remessa`.`medicoes-id` = me.`id`) INNER JOIN `casas` ca ON me.`casa-id` = ca.`id` AND ca.`cedente-id` = $cedente_id AND ca.`excluido` = 0 INNER JOIN `sacado` sa ON ca.`sacado-id` = sa.`id` ORDER BY re.`id`");

	if(mysqli_num_rows($sql1) > 0){
        $remessas = $sql1->fetch_all();

        $last_remessa_id = -1;

        echo "[";

        foreach($remessas as $key=>$remessa){
            if($remessa[0] != $last_remessa_id || $last_remessa_id == -1 ){
                $last_remessa_id = $remessa[0];

                echo "{";

                echo "\"id\":\"";
                echo $remessa[0];
                echo "\",";

                echo "\"data\":\"";
                echo $remessa[1];
                echo "\",";

                echo "\"arquivoRemessa\":\"";
                echo $remessa[2];
                echo "\",";

                echo "\"arquivoRetorno\":\"";
                echo $remessa[3];
                echo "\",";

                echo "\"enviado\":\"";
                echo $remessa[4];
                echo "\",";

                echo "\"dataEnvio\":\"";
                echo $remessa[5];
                echo "\",";

                echo "\"medicoes\":[";
            }
            
            echo "{"; //abrindo medicao
            
            echo "\"id\":\"";
            echo $remessa[6];
            echo "\",";
            
            echo "\"dataMedicao\":\"";
            echo $remessa[7];
            echo "\",";
            
            echo "\"boletoGerado\":\"";
            echo $remessa[8];
            echo "\",";

            echo "\"dataBoletoGerado\":\"";
            echo $remessa[9];
            echo "\",";
            
            echo "\"medicao\":\"";
            echo $remessa[10];
            echo "\",";

            echo "\"medicaoAnterior\":\"";
            echo $remessa[11];
            echo "\",";

            echo "\"carteiraSelecionada\":\"";
            echo $remessa[12];
            echo "\",";

            echo "\"contaSelecionadaIndex\":\"";
            echo $remessa[13];
            echo "\",";

            echo "\"medidor\":{"; // abrindo medidor
            
            echo "\"id\":\"";
            echo $remessa[14];
            echo "\",";
            
            echo "\"nome\":\"";
            echo $remessa[15];
            echo "\",";

            echo "\"cpf\":\"";
            echo $remessa[16];
            echo "\"";

            echo "},"; //fechando medidor

            echo "\"sacado\":{"; // abrindo sacado
            
            echo "\"id\":\"";
            echo $remessa[17];
            echo "\",";

            echo "\"nome\":\"";
            echo $remessa[18];
            echo "\",";

            echo "\"email\":\"";
            echo $remessa[19];
            echo "\",";

            echo "\"documento\":\"";
            echo $remessa[20];
            echo "\",";

            echo "\"avalista\":\"";
            echo $remessa[21];
            echo "\",";

            echo "\"avalistaDocumento\":\"";
            echo $remessa[22];
            echo "\"";

            echo "},"; //fechando sacado

            echo "\"casa\":{"; // abrindo casa
            
            echo "\"id\":\"";
            echo $remessa[23];
            echo "\",";

            echo "\"bairro\":\"";
            echo $remessa[24];
            echo "\",";

            echo "\"cidade\":\"";
            echo $remessa[25];
            echo "\",";

            echo "\"diaVencimento\":\"";
            echo $remessa[26];
            echo "\",";

            echo "\"referencia\":\"";
            echo $remessa[27];
            echo "\",";

            echo "\"numHidrometro\":\"";
            echo $remessa[28];
            echo "\",";

            echo "\"numero\":\"";
            echo $remessa[29];
            echo "\",";

            echo "\"rua\":\"";
            echo $remessa[30];
            echo "\",";

            echo "\"uf\":\"";
            echo $remessa[31];
            echo "\",";

            echo "\"cep\":\"";
            echo $remessa[32];
            echo "\"";

            echo "}"; //fechando casa

            echo "}"; //fechando medicao

            if($key+1 < sizeof($remessas)){
                if($remessas[$key+1][0] != $remessa[0]){
                    echo "]},"; 
                }else{
                    echo ",";
                }
            }else{
                echo "]}";
            }

            /*if($key+1 < sizeof($remessas)){
                echo "/";
                echo $remessas[$key+1][0];
            }*/
        }

        echo "]";
	}else{
		echo "erro";
   }
?>