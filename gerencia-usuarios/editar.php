<?php
include('../layout/header.php');
include('../layout/menu.php');
include('../banco/crud.php');

$usu_codigo = $_GET['usu-codigo'];

$dados_usuario = read("USUARIO", "WHERE USU_CODIGO = '$usu_codigo'");

$usu_nome = $dados_usuario[0]['USU_NOME'];
$usu_email = $dados_usuario[0]['USU_EMAIL'];
$usu_senha = $dados_usuario[0]['USU_SENHA'];
$usu_perfil = $dados_usuario[0]['USU_PERFIL'];
$usu_ativo = $dados_usuario[0]['USU_ISATIVO'];

$status = "";

if (isset($_GET['status'])) {
    $status = $_GET['status'];
}
?>

<div id="page-wrapper">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Editar usuário <i class="fa fa-long-arrow-right fa-fw"></i> <?php echo $usu_nome; ?></h3>
            </div>
            <div class="panel-body">
                <form action="valida-editar.php" method="POST">
                    <!--Campo id do usuario -->
                    <input type="hidden" id="id_usuario" value="<?php echo $usu_codigo; ?>" name="id_usuario" />

                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Nome" value="<?php echo $usu_nome; ?>" name="nome" required="required" />
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
                                Informe o nome completo.
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" required="required" class="form-control" name="email" value="<?php echo $usu_email; ?>"
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
                    </div>
                    <div class="col-sm-12">
                        <?php if ($status == "email-vazio") { ?>
                            <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                Informe o e-mail.
                            </div>
                        <?php } if ($status == "email-cadastrado") { ?>
                            <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                E-mail já cadastrado em outro usuário!
                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="perfil">Perfil</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="perfil" id="administrador" value="Administrador" <?php
                                if ($usu_perfil == 'Administrador') {
                                    echo 'checked';
                                }
                                ?>>
                                Administrador
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="perfil" id="usuario" value="Usuario"<?php
                                if ($usu_perfil == 'Usuario') {
                                    echo 'checked';
                                }
                                ?>>
                                Usuário
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="ativo">Ativo?</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="ativo" id="sim" value="1" <?php
                                if ($usu_ativo == 1) {
                                    echo 'checked';
                                }
                                ?>>
                                Sim
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="ativo" id="nao" value="0" <?php
                                if ($usu_ativo == 0) {
                                    echo 'checked';
                                }
                                ?>>
                                Não
                            </label>
                        </div>
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
