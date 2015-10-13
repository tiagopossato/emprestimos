<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/crud.php');
require('../banco/querys.php');


$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}


$mat_codigo_entrada = "";
if (isset($_GET['mat-codigo-entrada'])) {
    $mat_codigo_entrada = $_GET['mat-codigo-entrada'];
    $material_entrada = read('MATERIAL', 'WHERE MAT_CODIGO = ' . $mat_codigo_entrada);
    $mat_nome_entrada = $material_entrada[0]['MAT_NOME'];
}




$mat_codigo = '';
if (isset($_GET['mat-codigo'])) {
    $mat_codigo = $_GET['mat-codigo'];

    $dados_material = read("MATERIAL", "WHERE MAT_CODIGO = '$mat_codigo'");

    $mat_nome = $dados_material[0]['MAT_NOME'];
    $mat_desc = $dados_material[0]['MAT_DESCRICAO'];
    $mat_isativo = $dados_material[0]['MAT_ISATIVO'];
}
?>

<div id="page-wrapper">
    <div class="col-lg-12">
        <?php if ($status == "entrada-ok") { ?>
            <div id="alerta-erro" class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Sucesso!</strong> Entrada de material realizada.
            </div>
        <?php } ?>
    </div>
    <div class="col-lg-8">
        <!-- AQUI VEM A TABELA-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Materias Cadastrados </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive ">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th class="text-center">Nome</th>
                                <!-- <th class="text-center">Descrição</th> -->
                                <th class="text-center">Quantidade</th>
                                <th class="text-center">Ativo?</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- php para preencher a tabela-->
                            <?php
                            $consulta = ler_materiais();
                            foreach ($consulta as $lista):
                                if (!$lista) {
                                    '<span>Nenhum registro encontrato</span>';
                                } else {
                                    ?>
                                <tbody id="efeito">
                                    <tr>
                                        <td><?php echo $lista['MAT_NOME']; ?></td>
                                        <td><?php echo $lista['QUANTIDADE']; ?></td>
                                        <td>
                                            <?php
                                            if ($lista['MAT_ISATIVO'] == 1) {
                                                echo 'Sim';
                                            } elseif ($lista['MAT_ISATIVO'] == 0) {
                                                echo 'Não';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="btn-group-sm" role="group" aria-label="...">
                                                <a href="cadastro.php?mat-codigo=<?php echo $lista['MAT_CODIGO']; ?>" title="Editar" class="btn btn-default tip" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-edit"></i></a>
                                                <a href="cadastro.php?mat-codigo-entrada=<?php echo $lista['MAT_CODIGO']; ?>" title="Entrada do material" class="btn btn-default tip" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-plus"></i></a>
                                                <a href="#" title="Descrição" class="btn btn-default" data-toggle="popover" data-placement="top" data-trigger="focus" data-content="<?php echo $lista['MAT_DESCRICAO']; ?>"><i class="fa fa-fw fa-eye"></i></a>
                                                <a href="local-material.php?id=<?php echo $lista['MAT_CODIGO']; ?>" title="Localização do material" class="btn btn-default tip" data-toggle="tooltip" data-placement="top"><i class="fa fa-fw fa-map-marker"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php
                            }
                        endforeach;
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($mat_codigo_entrada)) { ?>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> 
                        <?php if (empty($mat_codigo)) { ?>
                            Cadastro de Material
                        <?php } elseif (!empty($mat_codigo)) { ?>
                            Editar Material
                        <?php } ?>
                    </h3>
                </div>
                <div class="panel-body">

                    <form class="form-horizontal" 
                    <?php if (empty($mat_codigo)) { ?>
                              action="valida-material.php"
                          <?php } elseif (!empty($mat_codigo)) { ?>
                              action="valida-editar-material.php"
                          <?php } ?>
                          method="POST">
                              <?php if (!empty($mat_codigo)) { ?>
                            <input type="hidden" id="mat-codigo" value="<?php echo $mat_codigo; ?>" name="mat-codigo" />
                        <?php } ?>
                        <div id="page-wrapper">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="" name="nome"
                                <?php if (!empty($mat_codigo)) { ?> 
                                           value="<?php echo $mat_nome; ?>"
                                       <?php } ?>>  

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
                                <textarea class="form-control" id="descricao" name="descricao" rows="3"><?php
                                    if (!empty($mat_codigo)) {
                                        echo $mat_desc;
                                    }
                                    ?> 
                                </textarea>
                            </div>

                            <?php if (!empty($mat_codigo)) { ?> 
                                <div class="form-group">
                                    <label for="ativo">Ativo?</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="ativo" id="sim" value="1" <?php
                                            if ($mat_isativo == 1) {
                                                echo 'checked';
                                            }
                                            ?>>
                                            Sim
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="ativo" id="nao" value="0" <?php
                                            if ($mat_isativo == 0) {
                                                echo 'checked';
                                            }
                                            ?>>
                                            Não
                                        </label>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($status == "ok") { ?>
                                <div id="alerta-erro" class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Sucesso!</strong> Material cadastrado.
                                </div>
                            <?php } if ($status == "alterado") { ?>
                                <div id="alerta-ok" class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Sucesso!</strong> Material alterado.
                                </div>
                            <?php } if ($status == "material-em-uso") { ?>
                                <div id="alerta-ok" class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Atenção!</strong> Material não pode ser inativado pois está sendo utilizado.
                                </div>
                            <?php } ?>

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary col-sm-12">
                                    <?php if (empty($mat_codigo)) { ?>
                                        Cadastrar
                                    <?php } elseif (!empty($mat_codigo)) { ?>
                                        Alterar
                                    <?php } ?>  
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } elseif (!empty($mat_codigo_entrada)) { ?>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Entrada de material</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="valida-entrada.php" method="POST">
                        <div id="page-wrapper">
                            <div class="form-group">
                                <input type="hidden" name="material-id" value="<?php echo $mat_codigo_entrada ?>">
                                <label for="material">Material</label>
                                <input type="text" class="form-control" id="material" value="<?php echo $mat_nome_entrada ?>" name="material-nome" disabled>
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
<?php } ?>
<!-- /.row -->
</div>
<!-- /.container-fluid -->


<?php
include('../layout/footer.php');
?>
