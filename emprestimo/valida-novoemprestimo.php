<?php

require('../banco/crud.php');
include('../banco/querys.php');
include('../sessao/validaSessao.php');


$usu_codigo = $_POST['usuario'];
$mat_codigo = $_POST['material'];
$loc_codigo = $_POST['local'];
$quantidade = $_POST['quantidade'];
$dataprevdev = $_POST['dataprevdev'];
$obs = $_POST['obs'];

$quant_linhas = count($mat_codigo);

$hoje = date('Y-m-d H:i:s');

//valida tudo antes de inserir
for ($i = 0; $i < $quant_linhas; $i++) {

    $str = 'WHERE MAT_CODIGO = "' . $mat_codigo[$i] . '"';
    $mat = read("MATERIAL", $str);
    if (!isset($mat)) {
        echo "Não foi possível ler na tabela MATERIAL" . "<br />";
        return;
    }

    $str = 'WHERE LOC_CODIGO = "' . $loc_codigo[$i] . '"';
    $loc = read("LOCAL", $str);
    if (!isset($loc)) {
        echo "Não foi possível ler na tabela LOCAL" . "<br />";
        return;
    }

    $str = 'WHERE MAT_CODIGO = "' . $mat_codigo[$i] .
            '" AND LOC_CODIGO = "' . $loc_codigo[$i] . '"';

    $locmat = read("LOCALMATERIAL", $str);
    if (!isset($locmat)) {
        $content = http_build_query(array(
            'status' => 'ops',
            'msg' => "<strong>OPERAÇÃO NÃO REALIZADA!</strong><br>"
            . "Não tem '" . $mat[0]['MAT_NOME'] . "' no " . $loc[0]['LOC_ABRV']
            . "<br> Verifique a localização do material no cadastro.",
        ));
        header("Location: novo.php?" . $content);
        return;
    }

    if ($quantidade[$i] > $locmat[0]['LOCMAT_QUANTIDADE']) {
        $content = http_build_query(array(
            'status' => 'ops',
            'msg' => "<strong>OPERAÇÃO NÃO REALIZADA!</strong><br>"
            . "Não tem " . $quantidade[$i] . " '" . $mat[0]['MAT_NOME'] .
            "' no " . $loc[0]['LOC_ABRV'] . "<br>"
            . "No máximo " . $locmat[0]['LOCMAT_QUANTIDADE'],
        ));
        header("Location: novo.php?" . $content);
        return;
    }

    echo 'Usuário: ' . $usu_codigo . '<br>';
    echo 'Local material: ' . $locmat[0]['LOCMAT_CODIGO'] . '<br>';
    echo 'Usário que autorizou: ' . $_SESSION['id'] . '<br>';
    echo "Data pre dev: " . $dataprevdev[$i] . "<br />";
    echo "Observações: " . $obs[$i] . "<br />";
    echo "Quantidade: " . $quantidade[$i] . "<br />";
    echo "Data emprestimo: " . $hoje . "<br><br>";

    echo "Material: " . $mat_codigo[$i] . "<br />";
    echo "Local: " . $loc_codigo[$i] . "<br />";
}

//Somente insere se toda a validação estiver OK
for ($i = 0; $i < $quant_linhas; $i++) {
    $str = 'WHERE MAT_CODIGO = "' . $mat_codigo[$i] .
            '" AND LOC_CODIGO = "' . $loc_codigo[$i] . '"';
    $locmat = read("LOCALMATERIAL", $str);
    $dados = array('USU_CODIGO' => $usu_codigo,
        'LOCMAT_CODIGO' => $locmat[0]['LOCMAT_CODIGO'],
        'USU_AUTEMPCODIGO' => $_SESSION['id'],
        'EMP_DATAPREVDEV' => $dataprevdev[$i],
        'EMP_OBS' => $obs[$i],
        'EMP_QTD' => $quantidade[$i],
        'EMP_DATA' => $hoje,
    );
    insert('EMPRESTIMO', $dados);
}

 $content = http_build_query(array(
            'status' => 'ok'
        ));
        header("Location: novo.php?" . $content);
?>

