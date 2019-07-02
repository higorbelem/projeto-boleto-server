<?php
    include_once 'conexao.php';

    $data = json_decode(file_get_contents('php://input'), TRUE);
    $id_cedente = $data['id-cedente'];
    $busca = $data['busca'];
    
    $sql1 = $dbcon -> query("SELECT ca.`id`, ca.`rua`, ca.`numero`, ca.`bairro`, ca.`cidade`, ca.`UF`, ca.`num-hidrometro`, ca.`cep`, sa.`nome` FROM `casas` ca INNER JOIN `sacado` sa ON ca.`sacado-id` = sa.`id` AND ca.`cedente-id` = $id_cedente AND (ca.`rua` LIKE '%$busca%' OR ca.`numero` LIKE '%$busca%' OR ca.`bairro` LIKE '%$busca%' OR ca.`cidade` LIKE '%$busca%' OR ca.`UF` LIKE '%$busca%' OR ca.`cep` LIKE '%$busca%' OR sa.`nome` LIKE '%$busca%'  OR sa.`documento` LIKE '%$busca%')");

	if(mysqli_num_rows($sql1) > 0){
	    $casas = $sql1->fetch_all();
	    
	    echo "[";
	    
	    foreach($casas as $key=>$casa){
            echo "{";
            
            echo "\"id\":\"";
    		echo $casa[0];
    		echo "\",";
    		
    		echo "\"rua\":\"";
    		echo $casa[1];
    		echo "\",";
    		
    		echo "\"numero\":\"";
    		echo $casa[2];
    		echo "\",";
    		
    		echo "\"bairro\":\"";
    		echo $casa[3];
    		echo "\",";
    		
    		echo "\"cidade\":\"";
    		echo $casa[4];
    		echo "\",";
    		
    		echo "\"uf\":\"";
    		echo $casa[5];
    		echo "\",";
    		
    		echo "\"numHidrometro\":\"";
    		echo $casa[6];
    		echo "\",";
    		
    		echo "\"cep\":\"";
    		echo $casa[7];
    		echo "\",";
    	
    	    echo "\"sacado\":\"";
    		echo $casa[8];
    		echo "\"";
    	
    	    echo "}";
    	    if($key+1 < sizeof($casas)){
    	        echo ",";
    	    }
	    }
	    
	    echo "]";
	}else{
	    echo "erro-login";
    }

?>

