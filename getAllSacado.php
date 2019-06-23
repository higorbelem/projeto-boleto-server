<?php
	include_once 'conexao.php';

	$id = $_POST['id'];
	
	$sql1 = $dbcon -> query("SELECT sa.* FROM `cedente-tem-sacado` cesa, `sacado` sa WHERE cesa.`sacado-id` = sa.id AND cesa.`cedente-id` = '$id'");

	if(mysqli_num_rows($sql1) > 0){
        //echo "ok";
		
        /*$dados = $sql1->fetch_row();

        for($i = 0 ; $i < sizeof($dados) ; $i++){
            echo ";";
            echo $dados[$i];
		}*/
		
		echo "[";

		while($dados = $sql1->fetch_array()){
			echo "{";

			/*echo "\"id\":\"";
			echo $dados['id'];
			echo "\",";*/

			echo "\"SacadoCod\":\"";
			echo $dados['sacado-cod'];
			echo "\",";

			echo "\"Sacado\":\"";
			echo $dados['nome'];
			echo "\",";

			echo "\"Documento\":\"";
			echo $dados['documento'];
			echo "\",";

			echo "\"Endereco\":\"";
			echo $dados['endereco'];
			echo "\",";

			echo "\"Bairro\":\"";
			echo $dados['bairro'];
			echo "\",";

			echo "\"Cidade\":\"";
			echo $dados['cidade'];
			echo "\",";

			echo "\"Cep\":\"";
			echo $dados['uf'];
			echo "\",";

			echo "\"Avalista\":\"";
			echo $dados['avalista'];
			echo "\",";

			echo "\"AvalistaDocumento\":\"";
			echo $dados['avalista-documento'];
			echo "\",";

			echo "\"Email\":\"";
			echo $dados['email'];
			echo "\",";

			echo "},";
		}

		echo "]";

	}else{
		echo "erro";
	}
?>