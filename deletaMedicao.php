<?php
	include_once 'conexao.php';
	include_once('auth.php');
    
    $data = json_decode(file_get_contents('php://input'), TRUE);
    
    $auth_usr = $data['auth-usr'];
	$auth_psw = $data['auth-psw'];
	auth($auth_usr,$auth_psw);
	
    $id_medicao = $data['id-medicao'];
    //$id_medicao = $_POST['id-medicao'];    

    $sql1 = $dbcon -> query("SELECT * FROM `medicoes` WHERE `id` = $id_medicao AND `boleto-gerado` = 0");

    if(mysqli_num_rows($sql1) > 0){
       $sql2 = $dbcon -> query("DELETE FROM `medicoes` WHERE `id` = $id_medicao");

    	if($sql2){
            echo "ok";
    	}else{
    		echo "erro";
        }
	}else{
		echo "boleto-gerado";
    }
?>