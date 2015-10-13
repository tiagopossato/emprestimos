<?php
require('../banco/crud.php');

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmacao = $_POST['confirmacao'];

$dados = array('USU_ISATIVO' => 1, 'USU_EMAIL' => $email, 'USU_SENHA' => $senha, 'USU_PERFIL' => 'Usuario', 'USU_NOME' => $nome);

	$sql_email = read("USUARIO", "WHERE USU_EMAIL = '$email'");
	
	if(empty($nome)){
		header ("Location: ../usuario/criar-conta.php?status=nome-vazio");
	}else{	
		if(strstr($nome, ' ') == FALSE){
			header ("Location: ../usuario/criar-conta.php?status=nome-incompleto");
		}else{
			if (($sql_email)){
				header ("Location: ../usuario/criar-conta.php?status=email-cadastrado");
			}else{	
				if(empty($email)){
					header ("Location: ../usuario/criar-conta.php?status=email-vazio");
				}else{					
					if(strlen($senha) < 6){
						header ("Location: ../usuario/criar-conta.php?status=senha-curta");
					}else{	
						if($senha != $confirmacao){
							header ("Location: ../usuario/criar-conta.php?status=senha-incorreta");
						}else{
							insert('USUARIO', $dados);
							header ("Location: ../usuario/login.php?status=ok");
						}
					}
				}
			}
		}
	}

?>
