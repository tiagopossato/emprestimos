<?php

require '../phpmailer/PHPMailerAutoload.php';
include("../banco/conexao.php");
require('../banco/crud.php');

$usermail = $_GET['email'];
$usersenha = '';

for ($i = 0; $i < 6; $i++) {
    $usersenha = $usersenha . rand(0, 9);
}

//echo 'Email: ' . $usermail . "<br>";
//echo 'Senha: ' . $usersenha;

/*$sql_nome = mysql_query("SELECT USU_NOME FROM USUARIO WHERE USU_EMAIL = '$usermail'");

if (mysql_num_rows($sql_nome)) {
    $nome = mysql_fetch_assoc($sql_nome);
    //echo $nome['USU_NOME'];
} else {
    header("Location: ../usuario/login.php?status=email-invalido");
}*/

$sql_nome = read("USUARIO", "WHERE USU_EMAIL = '" . $usermail . "'");
$nome = $sql_nome[0]['USU_NOME'];

if ($sql_nome[0]['USU_ISATIVO'] == 0) {
    header("Location: ../usuario/login.php?status=inativo");
    return;
}

//echo 'Nome: ' . $nome;
//return;

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'sistemadeemprestimos@yahoo.com.br';                 // SMTP username
$mail->Password = 'sistema1234';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'sistemadeemprestimos@yahoo.com.br';
$mail->FromName = 'Sistema de Emprestimos';
$mail->addAddress($usermail);     // Add a recipient
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Recuperacao de senha';
$mail->Body = 'Ola ' . $nome . ', <br> Sua nova senha: ' . $usersenha;

if (!$mail->send()) {
    //echo 'Mensagem não pode ser enviada.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
    header("Location: ../usuario/login.php?status=senha-nao-alterada");
} else {
    //echo 'Mensagem foi enviada';
    $dados = array('USU_SENHA' => $usersenha);
    update('USUARIO', $dados, "WHERE USU_EMAIL = '" . $usermail . "'");
    header("Location: ../usuario/login.php?status=senha-alterada");
}
