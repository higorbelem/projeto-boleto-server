<?php
	include_once 'conexao.php';
	
	$id = $_POST['id'];

	$sql1 = $dbcon -> query("SELECT * FROM `cedentes` WHERE id = '$id' LIMIT 1");

	if(mysqli_num_rows($sql1) > 0){
        $dados = $sql1->fetch_array();

		echo "{";

		echo "\"CedenteCod\":\"";
		echo $dados['cedente-cod'];
		echo "\",";

		echo "\"Cedente\":\"";
		echo $dados['nome'];
		echo "\",";

		echo "\"Banco\":\"";
		echo $dados['banco'];
		echo "\",";

		echo "\"Agencia\":\"";
		echo $dados['agencia'];
		echo "\",";

		echo "\"Conta\":\"";
		echo $dados['conta'];
		echo "\",";

		echo "\"Carteira\":\"";
		echo $dados['carteira'];
		echo "\",";

		echo "\"CarteiraTipo\":\"";
		echo $dados['carteira-tipo'];
		echo "\",";

		echo "\"Modalidade\":\"";
		echo $dados['modalidade'];
		echo "\",";

		echo "\"Convenio\":\"";
		echo $dados['convenio'];
		echo "\",";

		echo "\"CodCedente\":\"";
		echo $dados['cod-cedente'];
		echo "\",";

		echo "\"UsoBanco\":\"";
		echo $dados['uso-banco'];
		echo "\",";

		echo "\"Cip\":\"";
		echo $dados['cip'];
		echo "\",";

		echo "\"UseSantander\":";
		echo $dados['use-santander'];
		echo ",";

		echo "\"Endereco\":\"";
		echo $dados['endereco'];
		echo "\",";

		echo "\"Praca\":\"";
		echo $dados['praca'];
		echo "\",";

		echo "\"Cnpj\":\"";
		echo $dados['cnpj'];
		echo "\",";

		echo "\"Informacoes\":\"";
		echo $dados['informacoes'];
		echo "\",";
		
		echo "}";
		/*while($dados = $sql1->fetch_array()){
			echo $dados['nome'];
		}*/
	}else{
		echo "erro";
	}
?>