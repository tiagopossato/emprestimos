<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/crud.php');

$status = "";

if (isset($_GET['status'])) {
    $status = $_GET['status'];
}
?>

<div id="page-wrapper">
    <div class="col-lg-12">
        <?php if ($status == "alterado") { ?>
            <div id="alerta-erro" class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Sucesso!</strong> Usuário alterado.
            </div>
        <?php } ?>
        <!-- AQUI VEM A TABELA-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Usuários Cadastrados </h3>
            </div>
            <div class="panel-body">
                <?php
                $listar = read('USUARIO');
                if (!$listar) {
                    ?>
                    <div id = "alerta-erro" class = "alert alert-warning alert-dismissible" role = "alert">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                        Nenhum usuário cadastrado.
                    </div>
                <?php } elseif ($listar) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">E-mail</th>
                                    <th class="text-center">Perfil</th>
                                    <th class="text-center">Ativo?</th>
                                    <th class="text-center">Ações</th>

                                </tr>
                            </thead>
                            <?php foreach ($listar as $lista): ?>
                                <tbody id="efeito">
                                    <tr>
                                        <td><?php echo $lista['USU_NOME']; ?></td>
                                        <td><?php echo $lista['USU_EMAIL']; ?></td>
                                        <td><?php echo $lista['USU_PERFIL']; ?></td>
                                        <td>
                                            <?php
                                            if ($lista['USU_ISATIVO'] == 1) {
                                                echo 'Sim';
                                            } elseif ($lista['USU_ISATIVO'] == 0) {
                                                echo 'Não';
                                            }
                                            ?>
                                        </td>
                                        <!-- <td class="text-center">editar.php | inativar.php</th> -->
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                                <a href="editar.php?usu-codigo=<?php echo $lista['USU_CODIGO']; ?>" title="Editar" class="btn btn-default tip" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-edit"></i></a>
                                                <!-- <a href="#" title="Inativar" class="btn btn-default"><i class="fa fa-fw fa-trash-o"></i></a> -->
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php
                            endforeach;
                            ?>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Fim da TABELA-->

        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
</div>

<?php
include('../layout/footer.php');
?>
