<?php

include("../banco/conexao.php");
require('../banco/crud.php');

function get_post_action($name) {
    $params = func_get_args();
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}

switch (get_post_action('login', 'esqueci')) {
    case 'login':
        login();
        break;

    case 'esqueci':
        $email = $_POST['email'];

        if (empty($email)) {
            header("Location: ../usuario/login.php?status=email-vazio");
            return;
        }

        $sql_email = read("USUARIO", "WHERE USU_EMAIL = '$email'");
        if (!$sql_email) {
            header("Location: ../usuario/login.php?status=email-invalido");
            return;
        }

        header("Location: ../usuario/envia-email.php?email=" . $email);

        break;

    default:
        header("Location: ../usuario/login.php?status=erro");
}

function login() {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = mysql_query("SELECT USU_EMAIL, USU_SENHA, USU_ISATIVO FROM USUARIO WHERE USU_EMAIL = '$email' AND USU_SENHA = '$senha';") or die(mysql_error());

    if (mysql_num_rows($sql) > 0) {

        $nome = read("USUARIO", "WHERE USU_EMAIL = '$email'");

        if ($nome[0]['USU_ISATIVO'] == 0) {
            header("Location: ../usuario/login.php?status=inativo");
        } elseif ($nome[0]['USU_ISATIVO'] == 1) {
            session_start();
            
            $_SESSION['login'] = $nome[0]['USU_NOME'];
            $_SESSION['id'] = $nome[0]['USU_CODIGO'];
            $_SESSION['perfil'] = $nome[0]['USU_PERFIL'];

            header("Location: ../inicio/home.php");
        }
    } else {
        header("Location: ../usuario/login.php?status=erro");
    }
}

?>
