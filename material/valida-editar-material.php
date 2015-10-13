<?php

require('../banco/crud.php');
include('../sessao/validaSessao.php');

$codigo = $_POST['mat-codigo'];
$nome = $_POST['nome'];
$desc = $_POST['descricao'];
$ativo = $_POST['ativo'];

$sql_material = read('LOCALMATERIAL', 'WHERE MAT_CODIGO = ' . $codigo);

//echo $codigo . "<br>" . $nome . "<br>" . $ativo;
//return;

if (empty($nome)) {
    header("Location: cadastro.php?mat-codigo=" . $codigo . "&status=nome-vazio");
    return;
} elseif ($sql_material and $ativo == 0) {
    header("Location: cadastro.php?mat-codigo=" . $codigo . "&status=material-em-uso");
    return;
} else {
    $dados = array('MAT_NOME' => $nome, 'MAT_DESCRICAO' => $desc, 'MAT_ISATIVO' => $ativo);
    update('MATERIAL', $dados, "WHERE MAT_CODIGO ='" . $codigo . "'");
    header("Location: cadastro.php?status=alterado");
}


























//require('../banco/crud.php');
//include('../sessao/validaSessao.php');
//
//$id_material = "";
//if (isset($_GET['id'])) {
//    $id_material = $_GET['id'];
//}
//
//$nome = "";
//if (isset($_POST['nome'])) {
//    $nome = $_POST['nome'];
//}
//
//$descricao = "";
//if (isset($_POST['descricao'])) {
//    $descricao = $_POST['descricao'];
//}
//
//$condicao = 'WHERE MAT_CODIGO = ' . $id_material;
//
//
//if (empty($nome)) {
//    header("Location: editar.php?id=".$id_material."&status=nome-vazio");
//    return;
//} else {
//    $dados = array('MAT_NOME' => $nome, 'MAT_DESCRICAO' => $descricao);
//    update('MATERIAL', $dados, $condicao);
//    header("Location: editar.php?id=".$id_material."&status=ok");
//}
?>

