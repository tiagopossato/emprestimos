<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/querys.php');
require('../banco/crud.php');
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">

                                    <?php
                                    if ($_SESSION['perfil'] == 'Administrador') {

                                        echo conta_todos_emprestimos();
                                    }
                                    if ($_SESSION['perfil'] == 'Usuario') {

                                        $qtd = conta('EMPRESTIMO', 'EMPRESTIMO.EMP_ISATIVO', 'EMPRESTIMO.EMP_ISATIVO=1 AND EMPRESTIMO.USU_CODIGO = ' . $_SESSION['id']);
                                        echo $qtd[0];
                                    }
                                    ?>

                                </div>
                                <div>Empréstimos em aberto!</div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($_SESSION['perfil'] == 'Administrador') {
                        ?>
                        <a href="../emprestimo/emprestimo.php">
                            <?php
                        }
                        if ($_SESSION['perfil'] == 'Usuario') {
                            ?>
                            <a href="../emprestimo/consulta-emprestimos.php">
                            <?php } ?>
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalhes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-briefcase fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">

                                    <?php
                                    if ($_SESSION['perfil'] == 'Administrador') {
                                        $qtd = conta('MATERIAL', 'MATERIAL.MAT_ISATIVO', 'MATERIAL.MAT_ISATIVO=1');
                                        echo $qtd[0];
                                    }
                                    if ($_SESSION['perfil'] == 'Usuario') {
                                        echo conta_mat_disp();
                                    }
                                    ?>
                                </div>
                                <div>
                                    <?php
                                    if ($_SESSION['perfil'] == 'Administrador') {
                                        echo 'Materiais cadastrados';
                                    }
                                    if ($_SESSION['perfil'] == 'Usuario') {
                                        echo 'Materiais disponíveis';
                                    }
                                    ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($_SESSION['perfil'] == 'Administrador') {
                        ?>
                        <a href="../material/cadastro.php">
                            <?php
                        }
                        if ($_SESSION['perfil'] == 'Usuario') {
                            ?>
                            <a href="../material/consulta.php">
                            <?php } ?>
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalhes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('../layout/footer.php');
?>
