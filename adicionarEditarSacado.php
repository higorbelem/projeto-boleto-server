<?php
	include_once 'conexao.php';
    
    $id_cedente = $_POST['id-cedente'];
    $id_sacado = $_POST['id-sacado'];
    $nome = $_POST['nome'];
    $documento = $_POST['documento'];
    $email = $_POST['email'];
	$dialog_mode = $_POST['dialog-mode'];
    $casas_add = $_POST['casas-add'];
    $casas_edit = $_POST['casas-edit'];

    $query = "";

    if($dialog_mode == "0"){
        $query = "INSERT INTO `sacado` (`nome`,`documento`,`avalista`,`avalista-documento`,`email`) VALUES ('$nome','$documento','0','0','$email')";
    }else if($dialog_mode == "1"){
        $query = "UPDATE `sacado` SET `nome` = '$nome',`documento` = '$documento',`email` = '$email' WHERE `id` = $id_sacado";
    }

	$sql1 = $dbcon -> query($query);

	if($sql1){

        $id_sacado_temp;
        if($dialog_mode == "0"){
            $id_sacado_temp = $dbcon->insert_id;

            $sql2 = $dbcon -> query("INSERT INTO `cedentes-sacado` (`id-cedente`, `id-sacado`) VALUES ('$id_cedente','$id_sacado_temp')");
            if(mysqli_num_rows($sql2) > 0){

            }
        }else if($dialog_mode == "1"){
            $id_sacado_temp = $id_sacado;
        }

        foreach ($casas_add as $value) {
            $array = explode (";", $value); 
			$sql3 = $dbcon -> query("INSERT INTO `casas` (`sacado-id`,`cedente-id`, `bairro`,`cep`,`cidade`,`num-hidrometro`,`numero`,`referencia`,`rua`,`uf`,`dia-vencimento`) VALUES ($id_sacado_temp, $id_cedente, '$array[0]', '$array[1]', '$array[2]', '$array[3]', '$array[4]', '$array[5]', '$array[6]', '$array[7]', '$array[8]')");
            if(mysqli_num_rows($sql3) > 0){

            }else{
                
            }
        }
        
        foreach ($casas_edit as $value) {
            $array = explode (";", $value); 
			$sql3 = $dbcon -> query("UPDATE `casas` SET `bairro` = '$array[1]', `cep` = '$array[2]', `cidade` = '$array[3]', `num-hidrometro` = '$array[4]', `numero` = '$array[5]', `referencia` = '$array[6]', `rua` = '$array[7]', `uf` = '$array[8]', `vencimento` = '$array[9]' WHERE `id` = $array[0]");
            if(mysqli_num_rows($sql3) > 0){

            }else{
                
            }
        }

        echo "ok";
	}else{
		echo "erro";
   }
?>