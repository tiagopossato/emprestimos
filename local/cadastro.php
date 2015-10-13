<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/crud.php');

$status = "";

if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$loc_codigo = '';

if (isset($_GET['loc-codigo'])) {
    $loc_codigo = $_GET['loc-codigo'];

    $dados_local = read("LOCAL", "WHERE LOC_CODIGO = '$loc_codigo'");

    $loc_nome = $dados_local[0]['LOC_NOME'];
    $loc_abrv = $dados_local[0]['LOC_ABRV'];
    $loc_isativo = $dados_local[0]['LOC_ISATIVO'];
}
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="col-lg-8">
            <!-- AQUI VEM A TABELA-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Locais Cadastrados </h3>
                </div>
                <div class="panel-body">
                    <?php
                    $listar = read('LOCAL');
                    if (!$listar) {
                        ?>
                        <div id = "alerta-erro" class = "alert alert-warning alert-dismissible" role = "alert">
                            <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                            Nenhum local cadastrado.
                        </div>
                    <?php } elseif ($listar) { ?>
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nome</th>
                                        <th class="text-center">Abreviatura</th>
                                        <th class="text-center">Ativo?</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <?php foreach ($listar as $lista): ?>
                                    <tbody id="efeito">
                                        <tr>
                                            <td><?php echo $lista['LOC_NOME']; ?></td>
                                            <td><?php echo $lista['LOC_ABRV']; ?></td>
                                            <td>
                                                <?php
                                                if ($lista['LOC_ISATIVO'] == 1) {
                                                    echo 'Sim';
                                                } elseif ($lista['LOC_ISATIVO'] == 0) {
                                                    echo 'Não';
                                                }
                                                ?>
                                            </td>
                                                <!-- <td class="text-center">editar.php | inativar.php</th> -->
                                            <td>
                                                <div class="btn-group-sm" role="group" aria-label="...">
                                                    <a href="cadastro.php?loc-codigo=<?php echo $lista['LOC_CODIGO']; ?>" title="Editar" class="btn btn-default tip" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-edit"></i></a>
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
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i>
                        <?php if (empty($loc_codigo)) { ?>
                            Cadastro de Local
                        <?php } elseif (!empty($loc_codigo)) { ?>
                            Editar Local
                        <?php } ?>                        
                    </h3>
                </div>
                <div class="panel-body">

                    <form class="form-horizontal" 
                    <?php if (empty($loc_codigo)) { ?>
                              action="valida-local.php"
                          <?php } elseif (!empty($loc_codigo)) { ?>
                              action="valida-editar-local.php"
                          <?php } ?>
                          method="POST">
                              <?php if (!empty($loc_codigo)) { ?>
                            <input type="hidden" id="loc-codigo" value="<?php echo $loc_codigo; ?>" name="loc-codigo" />
                        <?php } ?>
                        <div id="page-wrapper">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="" name="nome"
                                <?php if (!empty($loc_codigo)) { ?> 
                                           value="<?php echo $loc_nome; ?>"
                                       <?php } ?>>  

                            </div>
                            <div class="col-sm-12">
                                <?php if ($status == "nome-vazio") { ?>
                                    <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        Informe o nome do local.
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label for="abreviatura">Abreviatura</label>
                                <input type="text" class="form-control" id="abrev" placeholder="" name="abrev"
                                <?php if (!empty($loc_codigo)) { ?> 
                                           value="<?php echo $loc_abrv; ?>"
                                       <?php } ?>> 
                            </div>
                            <?php if ($status == "abrev-vazio") { ?>
                                <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    Informe a abreviatura.
                                </div>
                            <?php } ?>
                            <?php if (!empty($loc_codigo)) { ?> 
                                <div class="form-group">
                                    <label for="ativo">Ativo?</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="ativo" id="sim" value="1" <?php
                                            if ($loc_isativo == 1) {
                                                echo 'checked';
                                            }
                                            ?>>
                                            Sim
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="ativo" id="nao" value="0" <?php
                                            if ($loc_isativo == 0) {
                                                echo 'checked';
                                            }
                                            ?>>
                                            Não
                                        </label>
                                    </div>
                                </div>
                            <?php } ?> 
                            <?php if ($status == "ok") { ?>
                                <div id="alerta-ok" class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Sucesso!</strong> Local cadastrado.
                                </div>
                            <?php } if ($status == "alterado") { ?>
                                <div id="alerta-ok" class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Sucesso!</strong> Local alterado.
                                </div>
                            <?php } if ($status == "local-em-uso") { ?>
                                <div id="alerta-ok" class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Atenção!</strong> Local não pode ser inativado pois está sendo utilizado.
                                </div>
                            <?php } ?>

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary col-sm-12">
                                    <?php if (empty($loc_codigo)) { ?>
                                        Cadastrar
                                    <?php } elseif (!empty($loc_codigo)) { ?>
                                        Alterar
                                    <?php } ?>  
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->


    <!-- /.container-fluid -->
</div>


<?php
include('../layout/footer.php');
?>
