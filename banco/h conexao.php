<?php
//nome do servidor (127.0.0.1)
$servidor = "185.28.21.241";
//usuario do banco de dados
$userBanco = "u266434611_user";
//senha do banco de dados
$senhaBanco = "usuario";
//nome do banco de dados
$db = "u266434611_emp";
//executa a conexão com o banco, caso contrário mostra o erro ocorrido
$conexao = mysql_connect($servidor,$userBanco,$senhaBanco) or die (mysql_error());
//seleciona a base de dados daquela conexao, caso contrario mostra o erro ocorrido
$banco = mysql_select_db($db, $conexao) or die (mysql_error());

$mysqli = new mysqli($servidor, $userBanco, $senhaBanco, $db);

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>
