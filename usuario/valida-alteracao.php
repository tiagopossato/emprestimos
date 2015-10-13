<?php

require('../banco/crud.php');
include('../sessao/validaSessao.php');

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmacao = $_POST['confirmacao'];

$condicao = 'WHERE USU_CODIGO = ' . $_SESSION['id'];

if (empty($nome)) {
    header("Location: ../usuario/perfil.php?status=nome-vazio");
    return;
} else {
    if (strstr($nome, ' ') == FALSE) {
        header("Location: ../usuario/perfil.php?status=nome-incompleto");
        return;
    } else {
        if (!empty($senha) || !empty($confirmacao)) {
            if (strlen($senha) < 4) {
                header("Location: ../usuario/perfil.php?status=senha-curta");
                return;
            } else {
                if ($senha != $confirmacao) {
                    header("Location: ../usuario/perfil.php?status=senha-incorreta");
                    return;
                } else {
                    $dados = array('USU_SENHA' => $senha, 'USU_NOME' => $nome);
                    update('USUARIO', $dados, $condicao);
                    $_SESSION['login'] = $nome;
                    header("Location: ../usuario/perfil.php?status=ok");
                    return;
                }
            }
        }
    }
    $dados = array('USU_NOME' => $nome);
    update('USUARIO', $dados, $condicao);
    $_SESSION['login'] = $nome;
    header("Location: ../usuario/perfil.php?status=ok");
}
?>
