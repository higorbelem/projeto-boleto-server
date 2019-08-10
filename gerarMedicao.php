<?php
    include_once 'conexao.php';
    include_once('auth.php');

    $data = json_decode(file_get_contents('php://input'), TRUE);
    
    $auth_usr = $data['auth-usr'];
	$auth_psw = $data['auth-psw'];
	auth($auth_usr,$auth_psw);
	
    $casa_id = $data['casa-id'];
    $medidor_id = $data['medidor-id'];
    $medicao = $data['medicao'];

    /*DROP PROCEDURE IF EXISTS transac;

    DELIMITER //
    
    CREATE PROCEDURE transac(idCasaParam INTEGER, idMedidorParam INTEGER, medicaoParam INTEGER)
    BEGIN
        DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
        START TRANSACTION;
    
        SET @medicao = (SELECT `medicao` FROM `medicoes` WHERE `id` = (SELECT max(`id`) FROM `medicoes` WHERE `casa-id` = idCasaParam));
    
        IF (medicaoParam < @medicao) THEN
            SELECT "menor" as 'return-value';
            ROLLBACK;
        ELSE
            IF (@medicao IS NULL) THEN
                INSERT INTO `medicoes`(`casa-id`, `medidor-id`, `data-medicao`,`data-referencia`, `medicao`) VALUES (idCasaParam, idMedidorParam, CONVERT_TZ(NOW(),'-03:00',@@global.time_zone), DATE_SUB(CONVERT_TZ(CURDATE(),'-03:00',@@global.time_zone),INTERVAL 1 MONTH), medicaoParam);
            ELSE
                INSERT INTO `medicoes`(`casa-id`, `medidor-id`, `data-medicao`,`data-referencia`, `medicao`, `medicao-anterior`) VALUES (idCasaParam, idMedidorParam, CONVERT_TZ(NOW(),'-03:00',@@global.time_zone), DATE_SUB(CONVERT_TZ(CURDATE(),'-03:00',@@global.time_zone),INTERVAL 1 MONTH), medicaoParam, @medicao);
            END IF;
            SELECT "ok" as 'return-value';
            COMMIT;
        END IF;
    END//
    
    DELIMITER ;*/
    
    $sql1 = $dbcon -> query("
    CALL transac($casa_id,$medidor_id,$medicao);
    ");

    if(mysqli_num_rows($sql1) > 0){
        $dados = $sql1->fetch_array();

        if($dados['return-value'] == 'ok'){
            echo "ok";
        }else if($dados['return-value'] == 'menor'){
            echo "medicao-menor";
        }else{
            echo "erro-login";
        }
    }else{
        echo "erro-login";
    }
    
    /*$sql1 = $dbcon -> query("SELECT `medicao` FROM `medicoes` WHERE `id` = (SELECT max(`id`) FROM `medicoes` WHERE `casa-id` = $casa_id)");
    
    
	if(mysqli_num_rows($sql1) > 0){
      $dados = $sql1->fetch_array();
      
        if($medicao < $dados['medicao']){
            echo "medicao-menor";
        }else{
            $sql2 = $dbcon -> query("INSERT INTO `medicoes`(`casa-id`, `medidor-id`, `data-medicao`, `medicao`, `medicao-anterior`) SELECT $casa_id, $medidor_id, CONVERT_TZ(NOW(),'+03:00',@@global.time_zone), $medicao, `medicao` FROM `medicoes` WHERE `id` = (SELECT max(`id`) FROM `medicoes` WHERE `casa-id` = $casa_id)");

        	if($sql2){
        	    echo "ok";
        	}else{
        	    echo "erro-login";
            }
        }
	    
	}else{
	    $sql3 = $dbcon -> query("INSERT INTO `medicoes`(`casa-id`, `medidor-id`, `data-medicao`, `medicao`) VALUES ($casa_id, $medidor_id, CONVERT_TZ(NOW(),'+03:00',@@global.time_zone), $medicao)");

    	if($sql3){
    	    echo "ok";
    	}else{
    	    echo "erro-login";
        }
	}*/

?>

