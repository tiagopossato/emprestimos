<?php

require('../banco/crud.php');
include('../sessao/validaSessao.php');

$locmat_codigo = $_POST['locmat'];
$qtd = $_POST['qtd'];
$motivo = $_POST['motivo'];

$material = $_POST['matcodigo'];

$sql_localmaterial = read("LOCALMATERIAL", "WHERE LOCMAT_CODIGO=" . $locmat_codigo);
$qtd_atual = $sql_localmaterial[0]['LOCMAT_QUANTIDADE'];
//echo 'Quantidade atual: '. $qtd_atual . '<br>';
//echo 'Quantidade passada: '. $qtd . '<br>';
$qtd_nova = $qtd_atual - $qtd;
//echo 'Quantidade nova: '. $qtd_nova . '<br>';

$dados_baixa = array('USU_CODIGO' => $_SESSION['id'], 'LOCMAT_CODIGO' => $locmat_codigo, 'MATBAIXA_QTD' => $qtd, 'MATBAIXA_MOTIVO' => $motivo);
insert('MATERIALBAIXAESTRAGO', $dados_baixa);
$dados_localmaterial = array('LOCMAT_QUANTIDADE' => $qtd_nova);
update("LOCALMATERIAL", $dados_localmaterial, "WHERE LOCMAT_CODIGO=" . $locmat_codigo);
header("Location: local-material.php?id=$material&status=baixa-ok");

?>
