<?php
	include_once 'conexao.php';
	include_once('auth.php');
	
	$auth_usr = $_POST['auth-usr'];
	$auth_psw = $_POST['auth-psw'];
	
	auth($auth_usr,$auth_psw);
    
    $id_cedente = $_POST['id-cedente'];
    $id_sacado = $_POST['id-sacado'];
    $nome = $_POST['nome'];
    $documento = $_POST['documento'];
    $email = $_POST['email'];
	$dialog_mode = $_POST['dialog-mode'];
    $casas_add = $_POST['casas-add'];
    $casas_edit = $_POST['casas-edit'];

    /*DROP PROCEDURE IF EXISTS `editar-sacado`;

    DELIMITER //
    
    CREATE PROCEDURE `editar-sacado`(dialogMode INTEGER, idSacado INTEGER, idCedente INTEGER, nome VARCHAR(50), documento VARCHAR(20), email VARCHAR(70), queryAddCasas TEXT, queryEditCasas TEXT)
    exit_proc:BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
 	BEGIN
    		ROLLBACK;
    		RESIGNAL;
  	END;

        SET autocommit=0;
	START TRANSACTION;

        IF (dialogMode = 0) THEN
            INSERT INTO `sacado` (`nome`,`documento`,`avalista`,`avalista-documento`,`email`) VALUES (nome,documento,'0','0',email);
            
	        SET @idSacadoTemp = (SELECT LAST_INSERT_ID());
            INSERT INTO `cedentes-sacado` (`id-cedente`, `id-sacado`) VALUES (idCedente,@idSacadoTemp);
        ELSE 
            IF (dialogMode = 1) THEN
                UPDATE `sacado` SET `nome` = nome,`documento` = documento,`email` = email WHERE `id` = idSacado;
                SET @idSacadoTemp = idSacado;
            ELSE   
                SELECT "erro" as 'return-value';
                ROLLBACK;
		        LEAVE exit_proc;
            END IF;
        END IF; 

        IF (queryAddCasas IS NOT NULL) THEN
            SET @query_as_string = (SELECT REPLACE(queryAddCasas,'id_sacado_temp_subst',@idSacadoTemp));
            PREPARE statement_1 FROM @query_as_string;
            EXECUTE statement_1;
            DEALLOCATE PREPARE statement_1;
        END IF;

        IF (queryEditCasas IS NOT NULL) THEN
            SET @query_as_string = (SELECT REPLACE(queryEditCasas,'id_sacado_temp_subst',@idSacadoTemp));
            PREPARE statement_1 FROM @query_as_string;
            EXECUTE statement_1;
            DEALLOCATE PREPARE statement_1;
        END IF;

        SELECT "ok" as 'return-value';
        COMMIT;
    END//
    
    DELIMITER ;*/
    
    //echo sizeof($casas_edit) . " as" . $casas_edit[0] . "as";
    //echo sizeof($casas_add) . " as" . $casas_add[0] . "as";

    if(sizeof($casas_add) > 0 && $casas_add[0] != ""){
        $queryAddCasas = "INSERT INTO `casas` (`sacado-id`,`cedente-id`, `bairro`,`cep`,`cidade`,`num-hidrometro`,`numero`,`referencia`,`rua`,`uf`,`dia-vencimento`,`valor-maximo-hidrometro`) VALUES ";
        foreach ($casas_add as $value) {
            $array = explode (";", $value); 
            $queryAddCasas .= "('id_sacado_temp_subst', $id_cedente, '$array[0]', '$array[1]', '$array[2]', '$array[3]', '$array[4]', '$array[5]', '$array[6]', '$array[7]', '$array[8]', '$array[9]'),";
        }
        $queryAddCasas = rtrim($queryAddCasas, ',');
        $queryAddCasas = "\"" . $queryAddCasas . "\"";
    }else{
        $queryAddCasas = "NULL";
    }
    
    if(sizeof($casas_edit) > 0 && $casas_edit[0] != ""){
        $queryEditCasas = "INSERT INTO `casas` (`id`,`sacado-id`,`cedente-id`, `bairro`,`cep`,`cidade`,`num-hidrometro`,`numero`,`referencia`,`rua`,`uf`,`dia-vencimento`,`valor-maximo-hidrometro`) VALUES ";
        foreach ($casas_edit as $value) {
            $array = explode (";", $value);
            $queryEditCasas .= "($array[0], 'id_sacado_temp_subst', $id_cedente, '$array[1]', '$array[2]', '$array[3]', '$array[4]', '$array[5]', '$array[6]', '$array[7]', '$array[8]', '$array[9]','$array[10]'),"; 
            //$sql3 = $dbcon -> query("UPDATE `casas` SET `bairro` = '$array[1]', `cep` = '$array[2]', `cidade` = '$array[3]', `num-hidrometro` = '$array[4]', `numero` = '$array[5]', `referencia` = '$array[6]', `rua` = '$array[7]', `uf` = '$array[8]', `vencimento` = '$array[9]' WHERE `id` = $array[0]");
        }
        $queryEditCasas = rtrim($queryEditCasas, ',');
        $queryEditCasas .= " ON DUPLICATE KEY UPDATE `sacado-id`=VALUES(`sacado-id`),`cedente-id`=VALUES(`cedente-id`),`bairro`=VALUES(`bairro`),`cep`=VALUES(`cep`),`cidade`=VALUES(`cidade`),`num-hidrometro`=VALUES(`num-hidrometro`),`numero`=VALUES(`numero`),`referencia`=VALUES(`referencia`),`rua`=VALUES(`rua`),`uf`=VALUES(`uf`),`dia-vencimento`=VALUES(`dia-vencimento`)"; 
        $queryEditCasas = "\"" . $queryEditCasas . "\"";
    }else{
        $queryEditCasas = "NULL";
    }

    //echo $queryAddCasas;
    //echo "CALL `editar-sacado`($dialog_mode, $id_sacado, $id_cedente, '$nome', '$documento', '$email', $queryAddCasas, $queryEditCasas)";
    
    $sql1 = $dbcon -> query("CALL `editar-sacado`($dialog_mode, $id_sacado, $id_cedente, '$nome', '$documento', '$email', $queryAddCasas, $queryEditCasas)");

    if(mysqli_num_rows($sql1) > 0){
        $dados = $sql1->fetch_array();

        if($dados['return-value'] == 'ok'){
            echo "ok";
        }else if($dados['return-value'] == 'erro'){
            echo "erro";
        }else{
            echo "erro";
        }
    }else{
        echo "erro";
    }

    /*$query = "";

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
    }*/
?>