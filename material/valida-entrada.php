<?php

require('../banco/crud.php');
include('../sessao/validaSessao.php');

$mat_codigo = $_POST['material-id'];

$loc_abrev = $_POST['local'];

$qtd = $_POST['qtd'];

//echo $mat_codigo . "<br>";
//echo $loc_abrev . "<br>";
//echo $qtd . "<br>";

//$str =  'WHERE MAT_NOME = "' . $mat_nome.'"';
//$material = read('MATERIAL',$str); 

$str =  'WHERE LOC_ABRV = "' . $loc_abrev.'"';
$local = read('LOCAL',$str);

$dados = array('LOC_CODIGO' => $local[0]['LOC_CODIGO'],
    'MAT_CODIGO' => $mat_codigo,
    'LOCMAT_QUANTIDADE' => $qtd);

//insert("LOCALMATERIAL", $dados);

call('FN_ENTRADA_MATERIAL', $dados);
header("Location: ../material/cadastro.php?status=entrada-ok");
?>

