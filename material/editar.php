<?php
include('../layout/header.php');
include('../layout/menu.php');
include('../banco/crud.php');

$id_material = "";
if (isset($_GET['id'])) {
    $id_material = $_GET['id'];
}

$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$material = read('MATERIAL', 'WHERE MAT_CODIGO = ' . $id_material);
?>

<div class="col-lg-6">
    <div class="panel-body">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Editar Material </h3>
            </div>

            <div class="panel-body">
                <form class="form-horizontal" action="valida-editar.php?id=<?php echo $id_material ?>" method="POST">
                    <div id="page-wrapper">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" placeholder="<?php echo $material[0]['MAT_NOME'] ?>" name=nome>
                        </div>
                        <div class="col-sm-12">
                            <?php if ($status == "nome-vazio") { ?>
                                <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    Informe o nome do material.
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" id="descricao" placeholder="<?php echo $material[0]['MAT_DESCRICAO'] ?>" name="descricao" rows="3"></textarea>
                        </div>
                        <?php if ($status == "ok") { ?>
                            <div id="alerta-erro" class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Sucesso!</strong> Material cadastrado.
                            </div>
                        <?php } ?>

                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary col-lg-6">Gravar</button>
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
