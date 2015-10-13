<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/crud.php');
include('../banco/querys.php');

date_default_timezone_set('America/Sao_Paulo');
$data_atual = date('y/m/d');

$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}
?>

<div id="page-wrapper">
    <!-- Tabela -->
    <div class="col-lg-12">        
        <?php if ($status == "ok") { ?>
            <div id="alerta-erro" class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Sucesso!</strong> Devolução realizada.
            </div>
        <?php } ?>        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Gerência de Empréstimos </h3>
            </div>
            <div class="panel-body">                
                <?php
                $consulta = consulta_todos_emprestimos();
                if (!$consulta) {
                    ?>
                    <div id = "alerta-erro" class = "alert alert-warning alert-dismissible" role = "alert">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                        Não existe nenhum empréstimo em aberto.
                    </div>
                <?php } elseif ($consulta) { ?>

                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Em nome de quem está o empréstimo">Usuário</p></th>
                            <th class="text-center"><p>Material</p></th>
                            <th class="text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Quantidade restante a devolver">Qtd a devolver</p></th>
                            <th class="text-center"><p>Local</p></th>
                            <th class="text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Data em que foi realizado o empréstimo">Data emp</p></th>
                            <th class="text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Data prevista para devolução">Data prev dev</p></th>
                            <th class="text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Administrador que realizou o empréstimo">Autorizado por</p></th>  
                            <th class="text-center"><p>Ações</p></th>
                            </tr>
                            </thead>
                            <?php
                            foreach ($consulta as $lista):
                                ?>
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
                                        <td><?php echo $lista['USU_NOME']; ?></td>
                                        <td><?php echo $lista['MAT_NOME']; ?></td>
                                        <td><?php echo $lista['EMP_QTD']; ?></td>
                                        <td><?php echo $lista['LOC_ABRV']; ?></td>
                                        <td>
                                            <?php
                                            $data = $lista['EMP_DATA'];
                                            echo date('d/m/Y H:i', strtotime($data));
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $data = $lista['EMP_DATAPREVDEV'];
                                            echo date('d/m/Y', strtotime($data));
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $lista['USU_AUTEMP']; ?>
                                        </td>                                                
                                        <!-- <td class="text-center">editar.php | devolver.php</th> -->
                                        <td>
                                            <div class="btn-group-sm" role="group" aria-label="...">
                                                <a href="#" title="Editar" class="btn btn-default tip" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-edit"></i></a>
                                                <a href="devolver.php?id=<?php echo $lista['EMP_CODIGO']; ?>" title="Realizar Devolução" class="btn btn-default tip" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-share"></i></a>
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
        <div class="row">
            <div class="btn-group col-lg-12">
                <a class="btn btn-default btn-primary col-lg-4" href="../emprestimo/novo.php">Novo empréstimo</a>
                <a class="btn btn-default btn-primary col-lg-4" href="../emprestimo/finalizados.php">Empréstimos finalizados</a>                
                <a class="btn btn-default btn-primary col-lg-4" href="../emprestimo/consulta-emprestimos.php">Meus empréstimos</a>
            </div>
        </div>
    </div>
    <!-- fim da Tabela -->
</div>

<?php
include('../layout/footer.php');
?>
