<?php
    include_once 'conexao.php';

    $data = json_decode(file_get_contents('php://input'), TRUE);
    $id_cedente = $data['id-cedente'];
    $rua = $data['rua'];
    $numero = $data['numero'];
    $bairro = $data['bairro'];
    $cidade = $data['cidade'];
    $uf = $data['uf'];
    $cep = $data['cep'];
    
    $query = "SELECT ca.`id`, ca.`rua`, ca.`numero`, ca.`bairro`, ca.`cidade`, ca.`UF`, ca.`num-hidrometro`, ca.`cep`, sa.`nome` FROM `casas` ca INNER JOIN `sacado` sa ON ca.`sacado-id` = sa.`id` AND ca.`cedente-id` = $id_cedente AND ca.`excluido` = 0 AND (";
    
    $first = true;
    
    if($rua != null){
        $first = false;
        $query .= "ca.`rua` LIKE '%$rua%'";
    }
    
    if(!empty($numero)){
        if($first == false){
            $query .= " AND "; 
        }
        $first = false;
        $query .= "ca.`numero` LIKE '%$numero%'";
    }
    
    if(!empty($bairro)){
        if($first == false){
            $query .= " AND "; 
        }
        $first = false;
        $query .= "ca.`bairro` LIKE '%$bairro%'";
    }
    
    if(!empty($cidade)){
        if($first == false){
            $query .= " AND "; 
        }
        $first = false;
        $query .= "ca.`cidade` LIKE '%$cidade%'";
    }
    
    if(!empty($uf)){
        if($first == false){
            $query .= " AND "; 
        }
        $first = false;
        $query .= "ca.`uf` LIKE '%$uf%'";
    }
    
    if(!empty($cep)){
        if($first == false){
            $query .= " AND "; 
        }
        $first = false;
        $query .= "ca.`cep` LIKE '%$cep%'";
    }
    
    $query .=  ")";
    
    //echo $query;
    
    $sql1 = $dbcon -> query($query);

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

