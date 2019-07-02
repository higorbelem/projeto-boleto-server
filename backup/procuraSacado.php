<?php
	include_once 'conexao.php';
	
    $busca = $_POST['busca'];
    $buscarTodos = $_POST['buscar-todos'];
    $id_cedente = $_POST['id-cedente'];

    $query = "";

    if($buscarTodos == "1"){
        $query = "SELECT sa.* FROM `sacado` sa INNER JOIN `cedentes-sacado` cesa ON cesa.`id-sacado` = sa.`id` AND cesa.`id-cedente` = $id_cedente";
    }else{
        $query = "SELECT sa.* FROM `sacado` sa INNER JOIN `cedentes-sacado` cesa ON cesa.`id-sacado` = sa.`id` AND cesa.`id-cedente` = $id_cedente WHERE sa.`nome` LIKE '%$busca%' OR sa.`documento` LIKE '%$busca%'";
    }

    /*if($buscarTodos == "1"){
        $query = "SELECT sa.`id` as 'id-sacado', sa.`nome`, sa.`email`, sa.`documento`, sa.`avalista`, sa.`avalista-documento`, ca.`id` as 'id-casa',  ca.`bairro`, ca.`cidade`, ca.`dia-vencimento`, ca.`referencia`, ca.`num-hidrometro`, ca.`numero`, ca.`rua`,ca.`UF`, ca.`cep` FROM `sacado` sa INNER JOIN `casas` ca ON ca.`sacado-id` = sa.`id` AND ca.`cedente-id` = $id_cedente";
    }else{
        $query = "SELECT sa.`id` as 'id-sacado', sa.`nome`, sa.`email`, sa.`documento`, sa.`avalista`, sa.`avalista-documento`, ca.`id` as 'id-casa',  ca.`bairro`, ca.`cidade`, ca.`dia-vencimento`, ca.`referencia`, ca.`num-hidrometro`, ca.`numero`, ca.`rua`,ca.`UF`, ca.`cep` FROM `sacado` sa INNER JOIN `casas` ca ON ca.`sacado-id` = sa.`id` AND ca.`cedente-id` = $id_cedente WHERE sa.`nome` LIKE '%$busca%' OR sa.`documento` LIKE '%$busca%'";
    }*/

	$sql1 = $dbcon -> query($query);

	if(mysqli_num_rows($sql1) > 0){
        echo "[";

        while($dados = $sql1->fetch_array()){

            echo "{"; // abrindo sacado
            
            echo "\"id\":\"";
            echo $dados['id'];
            echo "\",";

            echo "\"nome\":\"";
            echo $dados['nome'];
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
            
            echo "\"casas\":[";

            $id_sacado =  $dados['id'];

            $sql2 = $dbcon -> query("SELECT * FROM `casas` WHERE `sacado-id` = $id_sacado AND `excluido` = 0");
            if(mysqli_num_rows($sql2) > 0){
                while($dados2 = $sql2->fetch_array()){
                    echo "{"; // abrindo casa
                    
                    echo "\"id\":\"";
                    echo $dados2['id'];
                    echo "\",";

                    echo "\"bairro\":\"";
                    echo $dados2['bairro'];
                    echo "\",";

                    echo "\"cidade\":\"";
                    echo $dados2['cidade'];
                    echo "\",";

                    echo "\"diaVencimento\":\"";
                    echo $dados2['dia-vencimento'];
                    echo "\",";

                    echo "\"referencia\":\"";
                    echo $dados2['referencia'];
                    echo "\",";

                    echo "\"numHidrometro\":\"";
                    echo $dados2['num-hidrometro'];
                    echo "\",";

                    echo "\"numero\":\"";
                    echo $dados2['numero'];
                    echo "\",";

                    echo "\"rua\":\"";
                    echo $dados2['rua'];
                    echo "\",";

                    echo "\"uf\":\"";
                    echo $dados2['UF'];
                    echo "\",";

                    echo "\"cep\":\"";
                    echo $dados2['cep'];
                    echo "\"";

                    echo "},"; //fechando casa
                }
            }
            echo "]},"; // abrindo sacado
        }

        echo "]";
	}else{
		echo "erro";
   }
?>