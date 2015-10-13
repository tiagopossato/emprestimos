<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/crud.php');

$mat_codigo = "";
if (isset($_GET['mat-codigo'])) {
    $mat_codigo = $_GET['mat-codigo'];
}
$material = read('MATERIAL', 'WHERE MAT_CODIGO = ' . $mat_codigo);

$mat_nome = $material[0]['MAT_NOME'];
?>
<div id="page-wrapper">
    <div class="col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Entrada de material </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="valida-entrada.php" method="POST">
                    <div id="page-wrapper">
                        <div class="form-group">
                            <input type="hidden" name="material-id" value="<?php echo $mat_codigo ?>">
                            <label for="material">Material</label>
                            <input type="text" class="form-control" id="material" value="<?php echo $mat_nome ?>" name="material-nome" disabled>
                        </div>
                        <div class="form-group">
                            <label for="local">Local</label>
                            <?php
                            $consulta = read("LOCAL", "WHERE LOC_ISATIVO=1");
                            if (!$consulta) {
                                ?>
                                <div id = "alerta-erro" class = "alert alert-warning alert-dismissible" role = "alert">
                                    <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                                    Nenhum local cadastrado. <br>
                                    <strong><a href="../local/cadastro.php" class="alert-warning">Cadastre um novo Local</a></strong>
                                </div>
                            <?php } elseif ($consulta) { ?>
                                <select id="local" name="local" class="form-control" required="">
                                    <?php
                                    foreach ($consulta as $lista):
                                        ?>
                                        <option><?php echo $lista['LOC_ABRV']; ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="qtd">Quantidade</label>
                            <input type="number" class="form-control" id="qtd" name="qtd" placeholder="" value="1" min="1">
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary col-sm-12">Entrada</button>
                                <!-- <button type="reset" class="btn btn-warning col-sm-offset-2 col-sm-5">Limpar Campos</button> -->
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include('../layout/footer.php');
?>
