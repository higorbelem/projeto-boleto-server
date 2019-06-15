<?php
	include_once 'conexao.php';
	
    $busca = $_POST['busca'];
    $buscarTodos = $_POST['buscar-todos'];

    $query = "";

    if($buscarTodos == "1"){
        $query = "SELECT * FROM `sacado`";
    }else{
        $query = "SELECT * FROM `sacado` WHERE `nome` LIKE '%$busca%' OR `documento` LIKE '%$busca%'";
    }

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

            echo "},"; //fechando sacado
        }

        echo "]";
	}else{
		echo "erro";
   }
?>