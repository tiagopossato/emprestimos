<?php

require('../banco/crud.php');
include('../sessao/validaSessao.php');

$codigo = $_POST['loc-codigo'];
$nome = $_POST['nome'];
$abrev = $_POST['abrev'];
$ativo = $_POST['ativo'];

$sql_local = read('LOCALMATERIAL', 'WHERE LOC_CODIGO = ' . $codigo);

//echo $codigo . "<br>" . $nome . "<br>" . $ativo;
//return;

if (empty($nome)) {
    header("Location: cadastro.php?loc-codigo=" . $codigo . "&status=nome-vazio");
    return;
} elseif (empty($abrev)) {
    header("Location: cadastro.php?loc-codigo=" . $codigo . "&status=abrev-vazio");
    return;
}elseif ($sql_local and $ativo == 0) {
    header("Location: cadastro.php?loc-codigo=" . $codigo . "&status=local-em-uso");
    return;
} else {
    $dados = array('LOC_NOME' => $nome, 'LOC_ABRV' => $abrev, 'LOC_ISATIVO' => $ativo);
    update('LOCAL', $dados, "WHERE LOC_CODIGO ='" . $codigo . "'");
    header("Location: cadastro.php?status=alterado");
}
?>
