<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/crud.php');
include('../banco/querys.php');
$id_emprestimo = "";

if (isset($_GET['id'])) {
    $id_emprestimo = $_GET['id'];
}
$emprestimo = read("EMPRESTIMO", "WHERE EMP_CODIGO = " . $id_emprestimo);
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Devolução</h3>
                </div>
                <div class="panel-body">
                    <div id="page-wrapper">
                        <form class="form-horizontal" action="valida-devolver.php" method="POST">
                            <div>
                                <input type="number" id="id_emprestimo" name="id_emprestimo"
                                       value="<?php echo $id_emprestimo; ?>" hidden="">
                            </div>
                            <div id="datadev" class="form-group">
                                <label for="datadev">Data devolução</label>
                                <input type="date" id="datadev" name="datadev"
                                       value="<?php
                                       echo date('Y-m-d');
                                       ?>"
                                       min="<?php
                                       echo date('Y-m-d', strtotime($emprestimo[0]['EMP_DATA']));
                                       ?>"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="qtd">Quantidade</label>
                                <input type="number" class="form-control" id="qtd"
                                       name="qtd" min="1"
                                       max="<?php echo $emprestimo[0]['EMP_QTD'] ?>"
                                       value="<?php echo $emprestimo[0]['EMP_QTD'] ?>"
                                       placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="Observacoes">Observações</label>
                                <textarea class="form-control" id="obs" name="obs" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary col-lg-12">Devolver</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
</div>

<?php
include('../layout/footer.php');
?>
