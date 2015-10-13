<?php
include('../layout/header.php');
include('../layout/menu.php');
include('../banco/crud.php');

$usuario = read("USUARIO", "WHERE USU_CODIGO = " . $_SESSION['id']);

$status = "";

if (isset($_GET['status'])) {
    $status = $_GET['status'];
}
?>
<div id="page-wrapper">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Editar usuário <i class="fa fa-long-arrow-right fa-fw"></i> <?php echo $_SESSION['login']; ?></h3>
            </div>
            <div class="panel-body">
                <form action="valida-alteracao.php" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Nome" value="<?php echo $usuario[0]['USU_NOME']; ?>" name="nome">
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
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="exemplo@exemplo.com" value="<?php echo $usuario[0]['USU_EMAIL']; ?>" name="email" disabled>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" placeholder="********" name="senha">
                    </div>
                    <div class="form-group">
                        <label for="confirmacao">Confirmação</label>
                        <input type="password" class="form-control" id="confirmacao" placeholder="********" name="confirmacao">
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
                        <?php } if ($status == "ok") { ?>
                            <div id="alerta-erro" class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Sucesso!</strong> Dados alterados.
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary col-sm-12">Alterar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include('../layout/footer.php');
?>
