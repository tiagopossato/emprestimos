<?php 

include("validaSessao.php");

session_destroy();

header ("Location:../usuario/login.php?status=logout");

?>
