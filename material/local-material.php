<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/crud.php');
require('../banco/querys.php');

$id_material = "";
if (isset($_GET['id'])) {
    $id_material = $_GET['id'];
}

$locmat = "";
if (isset($_GET['locmat'])) {
    $locmat = $_GET['locmat'];
}

$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}
?>
<div id="page-wrapper">

    <!-- Tabela -->
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Localização do material <i class="fa fa-long-arrow-right fa-fw"></i>  
                    <?php
                    $nome = read('MATERIAL', 'WHERE MAT_CODIGO = ' . $id_material);
                    echo $nome[0]['MAT_NOME'];
                    ?>

                </h3>
            </div>
            <div class="panel-body">
                <?php
                $consulta = consulta_local_material($id_material);
                if (!$consulta) {
                    ?>
                    <div id = "alerta-erro" class = "alert alert-warning alert-dismissible" role = "alert">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                        Este material não está vinculado a nenhum local.
                    </div>
                <?php } elseif ($consulta) { ?>
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Local</th>
                                    <th class="text-center">Disponível</th>
                                    <th class="text-center">Emprestados</th>
                                    <th class="text-center">Total local</th>  
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <?php foreach ($consulta as $lista): ?>
                                <tbody id="efeito">
                                    <tr>
                                        <td><?php echo $lista['LOC_ABRV']; ?></td>
                                        <td><?php echo $lista['LOCMAT_QUANTIDADE']; ?></td>
                                        <td><?php
                                            if (isset($lista['QTD_EMPRESTADA'])) {
                                                echo $lista['QTD_EMPRESTADA'];
                                            } else {
                                                echo 0;
                                            }
                                            ?></td>
                                        <td><?php
                                            echo ($lista['LOCMAT_QUANTIDADE'] +
                                            $lista['QTD_EMPRESTADA']);
                                            ?></td>
                                        <td>
                                            <a href="local-material.php?id=<?php echo $id_material; ?>&locmat=<?php echo $lista['LOCMAT_CODIGO']; ?>" title="" class="btn btn-default btn-sm">Baixa / Ajuste</a>
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
    <!-- fim da Tabela -->

    <?php if ($status == "baixa-ok") { ?>
        <div id="alerta-erro" class="alert alert-success alert-dismissible col-lg-4" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Sucesso!</strong> Baixa de material realizada.
        </div>
    <?php } ?>

    <?php
    if (!empty($locmat)) {
        $sql_locmat = read("LOCALMATERIAL", "WHERE LOCMAT_CODIGO=" . $locmat);

        $locmat_idmaterial = $sql_locmat[0]['MAT_CODIGO'];
        $material = read("MATERIAL", "WHERE MAT_CODIGO=" . $locmat_idmaterial);
        $material_nome = $material[0]['MAT_NOME'];

        $locmat_idlocal = $sql_locmat[0]['LOC_CODIGO'];
        $local = read("LOCAL", "WHERE LOC_CODIGO=" . $locmat_idlocal);
        $local_nome = $local[0]['LOC_NOME'];
        $local_abreviatura = $local[0]['LOC_ABRV'];
        ?>
        <div class = "col-lg-4">
            <div class = "panel panel-default">
                <div class = "panel-heading">
                    <h3 class = "panel-title"><i class = "fa fa-long-arrow-right fa-fw"></i>
                        Baixa / Ajuste
                    </h3>
                </div>
                <div class="panel-body">
                    <div id="page-wrapper">
                        <form class="form-horizontal" action="valida-baixa.php" method="POST">
                            <input type="hidden" name="locmat" value="<?php echo $locmat; ?>">
                            <input type="hidden" name="matcodigo" value="<?php echo $id_material; ?>">
                            <div class="form-group">
                                <label for="material">Material</label>
                                <input type="text" class="form-control" id="material" value="<?php echo $material_nome; ?>" name="material" disabled>
                            </div>
                            <div class="form-group">
                                <label for="loca">Local</label>
                                <input type="text" class="form-control" id="local" value="<?php echo $local_nome; ?> - <?php echo $local_abreviatura; ?>" name="local" disabled>
                            </div>
                            <div class="form-group">
                                <label for="qtd">Quantidade</label>
                                <input type="number" class="form-control" id="qtd"
                                       name="qtd" min="1"
                                       max="<?php echo $sql_locmat[0]['LOCMAT_QUANTIDADE'] ?>"
                                       value="1"
                                       placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="motivo">Motivo</label>
                                <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
                            </div>

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary col-sm-12">
                                    Baixar / Ajustar
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>
<?php
include('../layout/footer.php');
?>
