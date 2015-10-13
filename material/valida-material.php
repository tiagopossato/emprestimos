<?php

require('../banco/crud.php');
include('../sessao/validaSessao.php');

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];

if (empty($nome)) {
    header("Location: cadastro.php?status=nome-vazio");
		return;
} else {
    $dados = array('MAT_NOME' => $nome, 'MAT_DESCRICAO' => $descricao);
    insert('MATERIAL', $dados);
  	header("Location: cadastro.php?status=ok");
}
?>
