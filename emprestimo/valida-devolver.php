<?php

require('../banco/crud.php');
include("../sessao/validaSessao.php");

$id_emprestimo = $_POST['id_emprestimo'];
$datadev = $_POST['datadev'];
$qtd = $_POST['qtd'];
$obs = $_POST['obs'];

$dados = array('EMP_CODIGO' => $id_emprestimo, 'DEV_DATA' => $datadev,
    'DEV_QTD' => $qtd, 'DEV_OBS' => $obs, 'USU_RECDEVCODIGO' => $_SESSION['id']);
insert('DEVOLUCAO', $dados);
header("Location: emprestimo.php?status=ok");
?>
