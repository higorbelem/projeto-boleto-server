<?php
    include_once 'conexao.php';

    $data = json_decode(file_get_contents('php://input'), TRUE);
    $casa_id = $data['casa-id'];
    $medidor_id = $data['medidor-id'];
    $medicao = $data['medicao'];

    /*$casa_id = $_GET['casa-id'];
    $medidor_id = $_GET['medidor-id'];
    $medicao = $_GET['medicao'];*/
    
    $sql1 = $dbcon -> query("SELECT `medicao` FROM `medicoes` WHERE `id` = (SELECT max(`id`) FROM `medicoes` WHERE `casa-id` = $casa_id)");
    
    
	if(mysqli_num_rows($sql1) > 0){
      $dados = $sql1->fetch_array();
      
        if($medicao < $dados['medicao']){
            echo "medicao-menor";
        }else{
            $sql2 = $dbcon -> query("INSERT INTO `medicoes`(`casa-id`, `medidor-id`, `data-medicao`, `medicao`, `medicao-anterior`) SELECT $casa_id, $medidor_id, CONVERT_TZ(NOW(),'-03:00',@@global.time_zone), $medicao, `medicao` FROM `medicoes` WHERE `id` = (SELECT max(`id`) FROM `medicoes` WHERE `casa-id` = $casa_id)");

        	if($sql2){
        	    echo "ok";
        	}else{
        	    echo "erro-login";
            }
        }
	    
	}else{
	    $sql3 = $dbcon -> query("INSERT INTO `medicoes`(`casa-id`, `medidor-id`, `data-medicao`, `medicao`) VALUES ($casa_id, $medidor_id, CONVERT_TZ(NOW(),'-03:00',@@global.time_zone), $medicao)");

    	if($sql3){
    	    echo "ok";
    	}else{
    	    echo "erro-login";
        }
	}

?>

