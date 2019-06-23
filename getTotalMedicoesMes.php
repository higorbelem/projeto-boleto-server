<?php
    include_once 'conexao.php';

    $cedente_id = $_POST['cedente-id'];

    $sql1 = $dbcon -> query("SELECT SUM(me.`medicao`) as 'medicoes-mes' FROM `medicoes` me INNER JOIN `casas` ca ON me.`casa-id` = ca.`id` AND ca.`cedente-id` = $cedente_id AND MONTH(me.`data-medicao`) = MONTH(NOW())");

    if(mysqli_num_rows($sql1) > 0){
        $dados = $sql1->fetch_array();

        echo $dados['medicoes-mes'];
    }else{
        echo "erro";
    }
?>