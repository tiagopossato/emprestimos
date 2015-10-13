<?php

include('../banco/crud.php');

$id_usuario = $_POST['id_usuario'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$perfil = $_POST['perfil'];
$ativo = $_POST['ativo'];

if (empty($nome)) {
    header("Location: editar.php?status=nome-vazio");
} else {
    if (strstr($nome, ' ') == FALSE) {
        header("Location: editar.php?status=nome-incompleto&usu-codigo=" . $id_usuario);
    } else {
        if (empty($email)) {
            header("Location: editar.php?status=email-vazio&usu-codigo=" . $id_usuario);
        } else {
            $sql_email = read("USUARIO", "WHERE USU_CODIGO <> '$id_usuario'");
            foreach ($sql_email as $lista) {

//            	echo $email."!= ";
//            	echo $lista['USU_EMAIL']."<br>";

                if ($email == $lista['USU_EMAIL']) {
                    header("Location: editar.php?status=email-cadastrado&usu-codigo=" . $id_usuario);
                }
            }
        }//else email vazio
    }//else nome vazio
}//else nome

$dados = array('USU_NOME' => $nome, 'USU_EMAIL' => $email, 'USU_PERFIL' => $perfil, 'USU_ISATIVO' => $ativo);
update('USUARIO', $dados, "WHERE USU_CODIGO = " . $id_usuario);

//header("Location: editar.php?status=ok&usu-codigo=" . $id_usuario);
header("Location: usuarios.php?status=alterado");


//echo $nome . "<br>";
//echo $email . "<br>";
?>
