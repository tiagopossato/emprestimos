<?php
include('../layout/header.php');

$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}
?>
<div class="col-lg-4 col-lg-offset-4" id="login">

    <?php if ($status == "ok") { ?>
        <div id="alerta-erro" class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Sucesso!</strong> Cadastro realizado. <br> Realize o login para acessar o sistema.
        </div>
    <?php } ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-user fa-3x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge">Login</div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form class = "form-horizontal" action = "../sessao/validaLogin.php" method = "POST">

                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@exemplo.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="senha" class="col-sm-2 control-label">Senha</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="********">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" name="login" class="btn btn-primary col-sm-12">Login</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <?php if ($status == "erro") { ?>
                            <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Erro!</strong> Email ou senha incorretos.
                            </div>
                        <?php } if ($status == "inativo") { ?>
                            <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Erro!</strong> Usuário inativado. <br>
                                Entre em contato com um Administrador.
                            </div>
                        <?php } if ($status == "sem-login") { ?>
                            <div id="alerta-erro" class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Atenção!</strong> Você precisa estar logado para acessar esta página.
                            </div>
                        <?php } if ($status == "logout") { ?>
                            <div id="alerta-erro" class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Sucesso!</strong> Usuário desconectado.
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div id="esqueceu-senha">
                    <button class="btn-link tip" type="submit" name="esqueci" data-toggle="tooltip" data-placement="right" 
                            title="Enviaremos uma nova senha para o email inserido acima"
                            >Esqueci minha senha</button>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <?php if ($status == "email-vazio") { ?>
                            <br>
                            <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Erro!</strong> Para recuperar sua senha preencha o campo Email.
                            </div>
                        <?php } if ($status == "email-invalido") { ?>
                            <br>
                            <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Erro!</strong> Email não cadastrado no sistema.
                            </div>
                        <?php } if ($status == "senha-nao-alterada") { ?>
                            <br>
                            <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Erro!</strong> Senha não pode ser enviada para o email solicitado.
                            </div>
                        <?php } if ($status == "senha-alterada") { ?>
                            <br>
                            <div id="alerta-erro" class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Sucesso!</strong> Em instantes enviaremos uma nova senha para o email solicitado.<br>
                                Verifique-a e tente realizar o login novamente.
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </form>  

        </div>
    </div>

    <div class="row" id="criar-conta">
        <div class="col-lg-12">
            <a class="btn btn-primary col-sm-12" href="criar-conta.php">Crie sua conta</a>
        </div>
    </div>
</div>

<?php
include('../layout/footer.php');
?>
