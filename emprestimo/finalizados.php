<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/querys.php');
require('../banco/crud.php');
?>

<div id="page-wrapper">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Empréstimos encerrados</h3>
            </div>
            <div class="panel-body">
                <?php
                $consulta = consulta_todos_emprestimos_encerrados();
                if (!$consulta) {
                    ?>
                    <div id = "alerta-erro" class = "alert alert-warning alert-dismissible" role = "alert">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                        Não existe nenhum empréstimo encerrado.
                    </div>
                <?php } elseif ($consulta) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center"><p>Usuário</p></th>
                            <th class="text-center"><p>Material</p></th>
                            <th class="text-center"><p>Quantidade</p></th>
                            <th class="text-center"><p>Local</p></th>
                            <th class="text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Data em que foi realizado o empréstimo">Data emp</p></th>
                            <th class="text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Data de devolução">Data dev</p></th>
                            <th class="text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Administrador que efetuou a devolução">Recebido por</p></th>
                            </tr>
                            </thead>
                            <?php foreach ($consulta as $lista): ?>
                                <TBODY id="efeito">
                                    <tr>
                                        <td><?php echo $lista['USU_NOME']; ?></td>
                                        <td><?php echo $lista['MAT_NOME']; ?></td>
                                        <td><?php echo $lista['DEV_QTD']; ?></td>
                                        <td><?php echo $lista['LOC_ABRV']; ?></td>
                                        <td>
                                            <?php
                                            $data = $lista['DEV_DATA'];
                                            echo date('d/m/Y H:i:s', strtotime($data));
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = $lista['EMP_DATA'];
                                            echo date('d/m/Y H:i:s', strtotime($data));
                                            ?>
                                        </td>
                                        <td><?php echo $lista['USU_RECDEV']; ?></td>
                                    </tr>
                                </TBODY>
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

