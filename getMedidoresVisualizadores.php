<?php
include_once 'conexao.php';
include_once('auth.php');

$auth_usr = $_POST['auth-usr'];
$auth_psw = $_POST['auth-psw'];

auth($auth_usr, $auth_psw);

$busca = $_POST['busca'];
$cedente_id = $_POST['cedente-id'];
$buscarTodos = $_POST['buscar-todos'];

if($buscarTodos == "1"){
    $sql1 = $dbcon->query("SELECT * FROM `contas-auxiliares` WHERE `cedente-id` = $cedente_id");
    //$sql1 = $dbcon->query("(SELECT *,'medidor' as tipo FROM medidor WHERE `cedente-id` = $cedente_id) UNION (SELECT *,'visualizador' as tipo FROM visualizadores WHERE `cedente-id` = $cedente_id)");
}else{
    $sql1 = $dbcon->query("SELECT * FROM `contas-auxiliares` WHERE `cedente-id` = $cedente_id AND (nome LIKE '%$busca%' OR cpf LIKE '%$busca%'");
    //$sql1 = $dbcon->query("(SELECT *,'medidor' as tipo FROM medidor WHERE `cedente-id` = $cedente_id AND (nome LIKE '%$busca%' OR cpf LIKE '%$busca%')) UNION (SELECT *,'visualizador' as tipo FROM visualizadores WHERE `cedente-id` = $cedente_id AND (nome LIKE '%$busca%' OR cpf LIKE '%$busca%'))");
}

if (mysqli_num_rows($sql1) > 0) {
    $jsonString = "ok;";

    $jsonString .= "[";

    while ($dados = $sql1->fetch_array()) {
        $jsonString .= "{";

        $jsonString .= "\"id\":\"";
        $jsonString .= $dados['id'];
        $jsonString .= "\",";

        $jsonString .= "\"cpf\":\"";
        $jsonString .= $dados['cpf'];
        $jsonString .= "\",";

        $jsonString .= "\"nome\":\"";
        $jsonString .= $dados['nome'];
        $jsonString .= "\",";

        $jsonString .= "\"tipo\":\"";
        $jsonString .= $dados['tipo'];
        $jsonString .= "\"";

        $jsonString .= "},";
    }

    $jsonString = rtrim($jsonString, ',');

    $jsonString .= "]";

    echo $jsonString;
} else {
    echo "erro";
}
