<?php
	include_once 'conexao.php';
	include_once('auth.php');
	
	$auth_usr = $_POST['auth-usr'];
	$auth_psw = $_POST['auth-psw'];
	
	auth($auth_usr,$auth_psw);
	
   $cedente_id = $_POST['cedente-id'];

	$sql1 = $dbcon -> query("SELECT re.`id` as 'id-remessa', re.`data`, re.`arquivo-remessa`, re.`arquivo-retorno`, re.`enviado`, re.`data-envio`, me.`id` as 'id-medicoes', me.`data-medicao`, me.`boleto-gerado`, me.`data-boleto-gerado`, me.`medicao`, me.`medicao-anterior`,me.`data-referencia`, me.`carteira-selecionada`, me.`conta-selecionada-index`, medidor.`id` as 'id-medidor', medidor.`nome` as 'nome-medidor', medidor.`cpf`, sa.`id` as 'id-sacado', sa.`nome` as 'nome-sacado', sa.`email`, sa.`documento`, sa.`avalista`, sa.`avalista-documento`, ca.`id` as 'id-casa', ca.`bairro`, ca.`cidade`, ca.`dia-vencimento`, ca.`referencia`, ca.`num-hidrometro`, ca.`valor-maximo-hidrometro`, ca.`numero`, ca.`rua`, ca.`UF`, ca.`cep` FROM `remessa` re INNER JOIN `medicoes-remessa` mere ON mere.`remessa-id` = re.`id` INNER JOIN `medicoes` me ON mere.`medicoes-id` = me.`id` INNER JOIN `medidor` ON me.`medidor-id` = medidor.`id` AND me.`boleto-gerado` = 1  AND 1 = (SELECT COUNT(*) FROM `medicoes-remessa` WHERE `medicoes-remessa`.`medicoes-id` = me.`id`) INNER JOIN `casas` ca ON me.`casa-id` = ca.`id` AND ca.`cedente-id` = $cedente_id AND ca.`excluido` = 0 INNER JOIN `sacado` sa ON ca.`sacado-id` = sa.`id` ORDER BY re.`id`");

	if(mysqli_num_rows($sql1) > 0){
        $remessas = $sql1->fetch_all();

        $last_remessa_id = -1;

        echo "ok;";

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

            echo "\"dataReferencia\":\"";
            echo $remessa[12];
            echo "\",";

            echo "\"carteiraSelecionada\":\"";
            echo $remessa[13];
            echo "\",";

            echo "\"contaSelecionadaIndex\":\"";
            echo $remessa[14];
            echo "\",";

            echo "\"medidor\":{"; // abrindo medidor
            
            echo "\"id\":\"";
            echo $remessa[15];
            echo "\",";
            
            echo "\"nome\":\"";
            echo $remessa[16];
            echo "\",";

            echo "\"cpf\":\"";
            echo $remessa[17];
            echo "\"";

            echo "},"; //fechando medidor

            echo "\"sacado\":{"; // abrindo sacado
            
            echo "\"id\":\"";
            echo $remessa[18];
            echo "\",";

            echo "\"nome\":\"";
            echo $remessa[19];
            echo "\",";

            echo "\"email\":\"";
            echo $remessa[20];
            echo "\",";

            echo "\"documento\":\"";
            echo $remessa[21];
            echo "\",";

            echo "\"avalista\":\"";
            echo $remessa[22];
            echo "\",";

            echo "\"avalistaDocumento\":\"";
            echo $remessa[23];
            echo "\"";

            echo "},"; //fechando sacado

            echo "\"casa\":{"; // abrindo casa
            
            echo "\"id\":\"";
            echo $remessa[24];
            echo "\",";

            echo "\"bairro\":\"";
            echo $remessa[25];
            echo "\",";

            echo "\"cidade\":\"";
            echo $remessa[26];
            echo "\",";

            echo "\"diaVencimento\":\"";
            echo $remessa[27];
            echo "\",";

            echo "\"referencia\":\"";
            echo $remessa[28];
            echo "\",";
 
            echo "\"numHidrometro\":\"";
            echo $remessa[29];
            echo "\",";

            echo "\"maxHidrometro\":\"";
            echo $remessa[30];
            echo "\",";

            echo "\"numero\":\"";
            echo $remessa[31];
            echo "\",";

            echo "\"rua\":\"";
            echo $remessa[32];
            echo "\",";

            echo "\"uf\":\"";
            echo $remessa[33];
            echo "\",";

            echo "\"cep\":\"";
            echo $remessa[34];
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