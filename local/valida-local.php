<?php

require('../banco/crud.php');
include('../sessao/validaSessao.php');

$nome = $_POST['nome'];
$abrev = $_POST['abrev'];

if (empty($nome)) {
    header("Location: cadastro.php?status=nome-vazio");
    return;
} else if (empty($abrev)) {
    header("Location: cadastro.php?status=abrev-vazio");
    return;
} else {
    $dados = array('LOC_NOME' => $nome, 'LOC_ABRV' => $abrev);
    insert('LOCAL', $dados);
    header("Location: cadastro.php?status=ok");
}
?>
