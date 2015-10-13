<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/querys.php');
require('../banco/crud.php');

date_default_timezone_set('America/Sao_Paulo');
$data_atual = date('y/m/d');
?>

<div id="page-wrapper">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Empréstimos em aberto</h3>
            </div>
            <div class="panel-body">
                <?php
                $consulta = consulta_emprestimos_abertos($_SESSION['id']);
                if (!$consulta) {
                    ?>
                    <div id = "alerta-erro" class = "alert alert-warning alert-dismissible" role = "alert">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                        Você não possui nenhum empréstimo em aberto.
                    </div>
                <?php } elseif ($consulta) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center"><p>Material</p></th>
                            <th class="text-center"><p>Local</p></th>
                            <th class="text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Quantidade restante a devolver">Qtd a devolver</p></th>                             
                            <th class="text-center"><p>Data de empréstimo</p></th>
                            <th class="text-center"><p>Data prevista de devolução</p></th>
                            </tr>
                            </thead>
                            <?php foreach ($consulta as $lista): ?>
                                <tbody id="efeito">
                                    <?php
                                    $data = $lista['EMP_DATAPREVDEV'];
                                    $data_devolucao = date('y/m/d', strtotime($data));
                                    ?>
                                    <tr
                                    <?php
                                    if ($data_devolucao < $data_atual) {
                                        echo ' class="danger"';
                                    } elseif ($data_devolucao == $data_atual) {
                                        echo ' class="warning"';
                                    }
                                    ?> >
                                        <td><?php echo $lista['MAT_NOME']; ?></td>
                                        <td><?php echo $lista['LOC_ABRV']; ?></td>
                                        <td><?php echo $lista['SALDO']; ?></td>
                                        <td>
                                            <?php
                                            $data = $lista['EMP_DATA'];
                                            echo date('d/m/Y H:i:s', strtotime($data));
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = $lista['EMP_DATAPREVDEV'];
                                            echo date('d/m/Y', strtotime($data));
                                            ?>
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

        </br>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Empréstimos finalizados</h3>
            </div>
            <div class="panel-body">
                <?php
                $consulta = consulta_emprestimos_encerrados($_SESSION['id']);
                if (!$consulta) {
                    ?>
                    <div id = "alerta-erro" class = "alert alert-warning alert-dismissible" role = "alert">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                        Você não possui nenhum empréstimo finalizado.
                    </div>
                <?php } elseif ($consulta) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Material</th>
                                    <th class="text-center">Local</th>
                                    <th class="text-center">Quantidade</th>
                                    <th class="text-center">Data de empréstimo</th>
                                    <th class="text-center">Data prevista de devolução</th>
                                    <th class="text-center">Data de devolução</th>
                                </tr>
                            </thead>
                            <?php
                            foreach ($consulta as $lista):
                                ?>
                                <tbody id="efeito">
                                    <tr>
                                        <td><?php echo $lista['MAT_NOME']; ?></td>
                                        <td><?php echo $lista['LOC_ABRV']; ?></td>
                                        <td><?php echo $lista['EMP_QTD']; ?></td>
                                        <td>
                                            <?php
                                            $data = $lista['EMP_DATA'];
                                            echo date('d/m/Y H:i:s', strtotime($data));
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = $lista['EMP_DATAPREVDEV'];
                                            echo date('d/m/Y H:i:s', strtotime($data));
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = $lista['DEV_DATA'];
                                            echo date('d/m/Y H:i:s', strtotime($data));
                                            ?>
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

    </div>
</div>
<?php
include('../layout/footer.php');
?>
