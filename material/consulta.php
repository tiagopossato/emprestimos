<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/crud.php');
require('../banco/querys.php');
?>

<div id="page-wrapper">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Materiais Cadastrados </h3>
            </div>
            <div class="panel-body">
                <?php
                $consulta = consulta_mat_disp();
                if (!$consulta) {
                    ?>
                    <div id = "alerta-erro" class = "alert alert-warning alert-dismissible" role = "alert">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                        Nenhum material cadastrado.
                    </div>
                <?php } elseif ($consulta) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">Quantidade disponível</th>
                                    <th class="text-center">Detalhes</th>
                                </tr>
                            </thead>
                            <?php foreach ($consulta as $lista): ?>
                                <tbody id="efeito">
                                    <tr>
                                        <td><?php echo $lista['MAT_NOME']; ?></td>
                                        <td><?php echo $lista['QTD']; ?></td>
                                        <td><?php echo $lista['MAT_DESCRICAO']; ?></td>
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
    </div>
</div>

<?php
include('../layout/footer.php');
?>
