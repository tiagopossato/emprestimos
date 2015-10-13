<?php
include('header.php');
include("../sessao/validaSessao.php");
?>

<div id="wrapper">
    <div class="row" id="menutopo">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="../inicio/home.php">Empréstimo de Materiais <i class="fa fa-shopping-cart"></i></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li>
                    <a href="../usuario/perfil.php"><i class="fa fa-fw fa-user"></i> <?php echo $_SESSION['login'] ?></a>
                </li>
                <li>
                    <a href="../sessao/logout.php"><i class="fa fa-fw fa-power-off"></i></a>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse" id="menulateral">
                <ul class="nav navbar-nav side-nav navbar-fixed-top">
                    <?php
                    if ($_SESSION['perfil'] == 'Administrador') {
                        ?>
                        <li>
                            <a href="../material/cadastro.php"><i class="fa fa-fw fa-briefcase"></i> Materiais</a>
                        </li>
                        <li>
                            <a href="../local/cadastro.php"><i class="fa fa-fw fa-map-marker"></i> Locais</a>
                        </li>
                        <li>
                            <a href="../emprestimo/emprestimo.php"><i class="fa fa-fw fa-tasks"></i> Empréstimos</a>
                        </li>
                        <li>
                            <a href="../gerencia-usuarios/usuarios.php"><i class="fa fa-fw fa-user"></i> Usuários</a>
                        </li>
                        <?php
                    }
                    if ($_SESSION['perfil'] == 'Usuario') {
                        ?>
                        <li>
                            <a href="../material/consulta.php"><i class="fa fa-fw fa-search"></i> Consultar Materiais</a>
                        </li>
                        <li>
                            <a href="../emprestimo/consulta-emprestimos.php"><i class="fa fa-fw fa-search"></i> Consultar Empréstimos</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
    </div>
