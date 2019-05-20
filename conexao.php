<?php
	$host = "localhost";
	$usuario = "root";
	$senha = "";
	$banco = "bd_boletos";

	$dbcon = new MySQLi("$host","$usuario","$senha","$banco");

	if($dbcon -> connect_error){
		echo "conexao_erro";
	}

	mysqli_query($dbcon, "SET NAMES UTF8");
?>