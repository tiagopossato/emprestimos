<?php
include('../layout/header.php');
include('../layout/menu.php');
require('../banco/querys.php');
require('../banco/crud.php');

 $status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$msg = "";
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

$locais = read("LOCAL", "WHERE LOC_ISATIVO=1");
$materiais = consulta_mat_disp();
$usuarios = read("USUARIO", "WHERE USU_ISATIVO=1");
date_default_timezone_set('America/Sao_Paulo');
$hoje = date('y/m/d');
?>

<div id="page-wrapper">

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Novo Empréstimo</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="valida-novoemprestimo.php">
                    <!--Área de notificação-->
                    <?php if ($status == "ok") { ?>
                        <div id="alerta-erro" class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Sucesso!</strong> Empréstimo realizado.
                        </div>
                    <?php } ?>

                    <?php if ($status == "ops") { ?>
                        <div id="alerta-erro" class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $msg; ?>
                        </div>
                    <?php } ?>

                    <!--Fim da área de notificação-->
                    <div class="form-group">
                        <label for="usuario">
                        <p class="tip" data-toggle="tooltip" data-placement="right" title="Em nome de quem será realizado o empréstimo">Usuário</p>
                        </label>
                        <select id="usuario" name="usuario" class="form-control" required>
                            <?php
                            foreach ($usuarios as $lista):
                                ?>
                                <option value="<?php echo $lista['USU_CODIGO']; ?>"><?php echo $lista['USU_NOME']; ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover text-center" id="materiais">
                            <!--<thead>-->
                            <tr class="LinhaCab">
                                <th class="TextoCab text-center">Material</th>
                                <th class="TextoCab text-center">Local</th>
                                <th class="TextoCab text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Quantidade a ser emprestada">Qtd</p></th>
                                <th class="TextoCab text-center"><p class="tip" data-toggle="tooltip" data-placement="top" title="Data prevista para devolução">Data prev dev</p></th>
                                <th class="TextoCab text-center">Observações</th>  
                                <th class="TextoCab text-center">Ações</th>
                            </tr>
                            <!--</thead>-->
                            <!--<tbody >-->
                            <tr>
                                <td > 
                                    <select id="material" name="material[]" class="form-control" required>
                                        <?php
                                        foreach ($materiais as $lista):
                                            ?>
                                            <option value="<?php echo $lista['MAT_CODIGO']; ?>"><?php echo $lista['MAT_NOME']; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                <td > 
                                    <select id="local" name="local[]" class="form-control" required>
                                        <?php
                                        foreach ($locais as $lista):
                                            ?>
                                            <option value="<?php echo $lista['LOC_CODIGO']; ?>"><?php echo $lista['LOC_ABRV']; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </td>
                                <td> <input class="form-control" name="quantidade[]" type="number" min="1" value="1" required> </td>

                                <td>
                                    <input type="date" id="datadev" name="dataprevdev[]"
                                           value="<?php
                                           echo date('Y-m-d',strtotime("+7 days"));
                                           ?>"
                                           min="<?php
                                           echo date('Y-m-d');
                                           ?>"
                                           class="form-control" required="">
                                </td>
                                <td> <input class="form-control" name="obs[]" type="text" /></td>                                      
                                <td><a href="javascript: void(0)" class="removerCampo TextoLista  btn btn-default">Remover</a></td>
                            </tr>
                            <!--</tbody>-->
                        </table>
                        <br>
                        <a href="javascript: void(0)" class="adicionarCampo TextoCab btn btn-default col-lg-12">Adicionar item ao empréstimo</a>
                        <!--Irá armazenar a quantidade de linhas-->
                        <!--<input type="hidden" value="1" name="quantidade_itens" />--> 
                        <!-- <br>
                        <table >
                            <tr class="LinhaCab col-lg-12">
                                <td colspan="3" align="center"><div align="center"><a href="javascript: void(0)" class="adicionarCampo TextoCab btn btn-default">Adicionar item ao empréstimo</a></div></td>
                                <button class="adicionarCampo TextoCab"> Adicionar </button>
                            </tr>
                        </table> -->    
                    </div>
                    <br>
                    <!--<div class="col-sm-12">-->
                    <button type="submit" class="btn btn-primary col-lg-12">Emprestar</button>
                    <!--</div>-->
                </form>
            </div>
        </div>
        <div class="row">
            <div class="btn-group col-lg-12">
                <!--botoes de ação-->
            </div>
        </div>
    </div>

</div>

<?php
include('../layout/footer.php');
?>

