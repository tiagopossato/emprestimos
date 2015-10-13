<?php
include('../layout/header.php');

$status = "";

if (isset($_GET['status'])) {
    $status = $_GET['status'];
}
?>	
<div class="col-lg-4 col-lg-offset-4" id="login">		
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-user fa-3x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge">Crie sua conta</div>
                </div>
            </div>
        </div>
        <div class="panel-body">					
            <form class="form-horizontal" action="valida-conta.php" method="POST">
                <div class="form-group">
                    <label for="nome" class="col-sm-2 control-label">Nome</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nome" placeholder="Nome" name="nome">
                    </div>
                </div>
                <div class="col-sm-12">							
<?php if ($status == "nome-vazio") { ?>
                        <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Informe o seu nome.
                        </div>
<?php } if ($status == "nome-incompleto") { ?>
                        <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Informe o seu nome completo.
                        </div>
<?php } ?>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" placeholder="exemplo@exemplo.com" name="email">
                    </div>
                </div>
                <div class="col-sm-12">							
<?php if ($status == "email-cadastrado") { ?>
                        <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Email já cadastrado.
                        </div>
<?php } if ($status == "email-vazio") { ?>
                        <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Informe o seu email.
                        </div>
<?php } ?>
                </div>
                <div class="form-group">
                    <label for="senha" class="col-sm-2 control-label">Senha</label>
                    <div class="col-sm-offset-1 col-sm-9">
                        <input type="password" class="form-control" id="senha" placeholder="********" name="senha">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmacao" class="col-sm-2 control-label">Confirmação</label>
                    <div class="col-sm-offset-1 col-sm-9">
                        <input type="password" class="form-control" id="confirmacao" placeholder="********" name="confirmacao">
                    </div>
                </div>
                <div class="col-sm-12">							
<?php if ($status == "senha-curta") { ?>
                        <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Informe uma senha de no mínimo 6 caracteres.
                        </div>
<?php } if ($status == "senha-incorreta") { ?>
                        <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            Confirmação de senha incorreta.
                        </div>
<?php } ?>
                </div>						
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary col-sm-12" name="criar-conta">Criar conta</button>
                    </div>
                </div>
            </form>    
        </div>
    </div>

    <div class="row" id="login">
        <div class="col-lg-12">
            <a class="btn btn-primary col-sm-12" href="login.php">Voltar</a>
        </div>
    </div>
</div>

<?php
include('../layout/footer.php');
?>