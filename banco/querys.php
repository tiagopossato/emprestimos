<?php

/* * ***************************
  FUNÇÃO PARA CONTAR QUANTIDADE DE LINHAS NA TABELA;
 * *************************** */

function conta($tabela, $coluna, $condicao = NULL) {
    $qrRead = "SELECT COUNT($coluna) FROM {$tabela} WHERE {$condicao}";
    $stRead = mysql_query($qrRead) or die('Erro ao ler em ' . $tabela . ' ' . mysql_error());
    return mysql_fetch_array($stRead, MYSQL_NUM);
}

/**
 * Conta a quantidade total de material, somando os disponíveis para empréstimo
 * e os emprestados
 * @param int $id_material
 * @return int
 */
function conta_qtd_total_material($id_material) {

    $qtd_emp = 0;

    $qtd_disp = soma('LOCALMATERIAL', 'LOCMAT_QUANTIDADE', 'MAT_CODIGO = ' . $id_material);
    $consulta = read('LOCALMATERIAL', 'WHERE MAT_CODIGO = ' . $id_material);
    if (isset($consulta)) {
        foreach ($consulta as $local):
            $qtd = soma('EMPRESTIMO', 'EMP_QTD', 'EMPRESTIMO.LOCMAT_CODIGO =' . $local['LOCMAT_CODIGO'] . ' AND EMPRESTIMO.EMP_ISATIVO = 1');
            if (isset($qtd)) {
                $qtd_emp += $qtd[0];
            }
        endforeach;
    }

    return $qtd_disp[0] + $qtd_emp;
}

/**
 * Soma todas as linhas da coluna na tabela
 * @param type $tabela
 * @param type $coluna
 * @param type $condicao
 * @return type
 */
function soma($tabela, $coluna, $condicao = NULL) {
    $qrRead = "SELECT SUM($coluna) FROM {$tabela} WHERE {$condicao}";
    //echo $qrRead;
    $stRead = mysql_query($qrRead) or die('Erro ao ler em ' . $tabela . ' ' . mysql_error());
    return mysql_fetch_array($stRead, MYSQL_NUM);
}

/* * ***************************
  FUNÇÃO PARA CONSULTAR MATERIAIS DISPONÍVES AO USUÁRIO
 * *************************** */

function consulta_mat_disp() {
    $resultado = "";
    $qrRead = "SELECT A.MAT_CODIGO, A.MAT_NOME, A.MAT_DESCRICAO, SUM(A.LOCMAT_QUANTIDADE) AS QTD FROM (SELECT MATERIAL.MAT_CODIGO, MATERIAL.MAT_NOME, LOCALMATERIAL.LOCMAT_QUANTIDADE, MATERIAL.MAT_DESCRICAO FROM MATERIAL,LOCALMATERIAL WHERE MATERIAL.MAT_CODIGO = LOCALMATERIAL.MAT_CODIGO AND MATERIAL.MAT_ISATIVO = 1) AS A GROUP BY A.MAT_NOME";
    $stRead = mysql_query($qrRead) or die('Erro ao ler em ' . $tabela . ' ' . mysql_error());
    $cField = mysql_num_fields($stRead);
    for ($y = 0; $y < $cField; $y++) {
        $names[$y] = mysql_field_name($stRead, $y);
    }
    for ($x = 0; $res = mysql_fetch_assoc($stRead); $x++) {
        for ($i = 0; $i < $cField; $i++) {
            $resultado[$x][$names[$i]] = $res[$names[$i]];
        }
    }
    if ($resultado != NULL) {
        return $resultado;
    } else {
        
    }
}

/* * ***************************
  FUNÇÃO PARA CONTAR MATERIAIS DISPONÍVES AO USUÁRIO
 * *************************** */

function conta_mat_disp() {
    $resultado = consulta_mat_disp();
    return sizeof($resultado);
}

/* * ***************************
  FUNÇÃO PARA CONSULTAR EMPRESTIMOS ATIVOS DO USUARIO
 * *************************** */

function consulta_emprestimos_abertos($usuario) {
    $resultado = "";
    $qrRead = "SELECT MATERIAL.MAT_NOME, LOCAL.LOC_ABRV, D.SALDO, D.EMP_DATA, D.EMP_DATAPREVDEV FROM MATERIAL,LOCAL, (
    SELECT LOCALMATERIAL.MAT_CODIGO, LOCALMATERIAL.LOC_CODIGO, C.SALDO, C.EMP_DATA, C.EMP_DATAPREVDEV FROM LOCALMATERIAL, (
   	 SELECT * FROM (
   		 SELECT A.LOCMAT_CODIGO, (A.EMP_QTD) AS SALDO, A.EMP_DATA, A.EMP_DATAPREVDEV FROM (
   			 SELECT * FROM EMPRESTIMO WHERE EMPRESTIMO.EMP_ISATIVO = 1 AND EMPRESTIMO.USU_CODIGO = " . $usuario . "
   		 ) AS A
   	 ) AS B
    ) AS C
WHERE LOCALMATERIAL.LOCMAT_CODIGO = C.LOCMAT_CODIGO
) AS D
WHERE MATERIAL.MAT_CODIGO = D.MAT_CODIGO AND LOCAL.LOC_CODIGO = D.LOC_CODIGO";
    //echo $qrRead;
    $stRead = mysql_query($qrRead) or die('Erro ao ler em ' . $tabela . ' ' . mysql_error());
    $cField = mysql_num_fields($stRead);
    for ($y = 0; $y < $cField; $y++) {
        $names[$y] = mysql_field_name($stRead, $y);
    }
    for ($x = 0; $res = mysql_fetch_assoc($stRead); $x++) {
        for ($i = 0; $i < $cField; $i++) {
            $resultado[$x][$names[$i]] = $res[$names[$i]];
        }
    }
    if ($resultado != NULL) {
        return $resultado;
    } else {
        
    }
}

/* * ***************************
  FUNÇÃO PARA CONSULTAR EMPRESTIMOS ENCERRADOS DO USUARIO
 * *************************** */

function consulta_emprestimos_encerrados($usuario) {
    $resultado = "";
    $qrRead = "SELECT MATERIAL.MAT_NOME, LOCAL.LOC_ABRV, SUM(DEV_QTD) AS EMP_QTD, D.EMP_DATA, D.EMP_DATAPREVDEV, DEVOLUCAO.DEV_DATA FROM MATERIAL, DEVOLUCAO, LOCAL, (
    SELECT LOCALMATERIAL.MAT_CODIGO, LOCALMATERIAL.LOC_CODIGO, C.EMP_QTD, C.EMP_DATA, C.EMP_DATAPREVDEV, C.EMP_CODIGO FROM LOCALMATERIAL, (
   	 SELECT * FROM (
   		 SELECT A.LOCMAT_CODIGO, A.EMP_QTD, A.EMP_DATA, A.EMP_DATAPREVDEV, A.EMP_CODIGO FROM (
   			 SELECT * FROM EMPRESTIMO WHERE EMPRESTIMO.EMP_ISATIVO = 0 AND EMPRESTIMO.USU_CODIGO = " . $usuario . "
   		 ) AS A
   	 ) AS B
    ) AS C
WHERE LOCALMATERIAL.LOCMAT_CODIGO = C.LOCMAT_CODIGO
) AS D
WHERE MATERIAL.MAT_CODIGO = D.MAT_CODIGO AND LOCAL.LOC_CODIGO = D.LOC_CODIGO AND DEVOLUCAO.EMP_CODIGO = D.EMP_CODIGO GROUP BY D.EMP_CODIGO";
    //echo $qrRead;
    $stRead = mysql_query($qrRead) or die('Erro ao ler em ' . $tabela . ' ' . mysql_error());
    $cField = mysql_num_fields($stRead);
    for ($y = 0; $y < $cField; $y++) {
        $names[$y] = mysql_field_name($stRead, $y);
    }
    for ($x = 0; $res = mysql_fetch_assoc($stRead); $x++) {
        for ($i = 0; $i < $cField; $i++) {
            $resultado[$x][$names[$i]] = $res[$names[$i]];
        }
    }
    if ($resultado != NULL) {
        return $resultado;
    } else {
        
    }
}

/**
 *
 * @return $lista['USU_NOME']   
  $lista['MAT_NOME']
  $lista['DEV_QTD']
  $lista['LOC_ABRV']
  $lista['EMP_DATA']
  $lista['DEV_DATA']
  $lista['USU_RECDEV']
 */
function consulta_todos_emprestimos_encerrados() {
    $resultado = "";
    $qrRead = "SELECT D.USU_CODIGO, LOCAL.LOC_ABRV, SUM(DEV_QTD) AS DEV_QTD, MATERIAL.MAT_NOME, D.EMP_DATA, DEVOLUCAO.DEV_DATA,DEVOLUCAO.USU_RECDEVCODIGO FROM MATERIAL, DEVOLUCAO, LOCAL, (
    SELECT LOCALMATERIAL.MAT_CODIGO, LOCALMATERIAL.LOC_CODIGO,C.USU_CODIGO, C.EMP_QTD, C.EMP_DATA, C.EMP_DATAPREVDEV, C.EMP_CODIGO FROM LOCALMATERIAL, (
   	 SELECT * FROM (
   		 SELECT A.USU_CODIGO,A.LOCMAT_CODIGO, A.EMP_QTD, A.EMP_DATA, A.EMP_DATAPREVDEV, A.EMP_CODIGO FROM (
   			 SELECT * FROM EMPRESTIMO WHERE EMPRESTIMO.EMP_ISATIVO = 0
   		 ) AS A
   	 ) AS B
    ) AS C
WHERE LOCALMATERIAL.LOCMAT_CODIGO = C.LOCMAT_CODIGO
) AS D
WHERE MATERIAL.MAT_CODIGO = D.MAT_CODIGO AND LOCAL.LOC_CODIGO = D.LOC_CODIGO AND DEVOLUCAO.EMP_CODIGO = D.EMP_CODIGO GROUP BY D.EMP_CODIGO";
    //echo $qrRead;
    $stRead = mysql_query($qrRead) or die('Erro ao ler em ' . $tabela . ' ' . mysql_error());
    $cField = mysql_num_fields($stRead);
    for ($y = 0; $y < $cField; $y++) {
        $names[$y] = mysql_field_name($stRead, $y);
    }
    for ($x = 0; $res = mysql_fetch_assoc($stRead); $x++) {
        for ($i = 0; $i < $cField; $i++) {
            $resultado[$x][$names[$i]] = $res[$names[$i]];
        }
    }
    if ($resultado != NULL) {
        for ($index = 0; $index < sizeof($resultado); $index++) {
            $nome = read('USUARIO', 'WHERE USU_CODIGO = ' . $resultado[$index]['USU_CODIGO']);
            $resultado[$index]['USU_NOME'] = $nome[0]['USU_NOME'];
            $nome = read('USUARIO', 'WHERE USU_CODIGO = ' . $resultado[$index]['USU_RECDEVCODIGO']);
            $resultado[$index]['USU_RECDEV'] = $nome[0]['USU_NOME'];
        }
        return $resultado;
    } else {
        
    }
}

function consulta_todos_emprestimos() {
    $resultado = "";
//	$qrRead = "SELECT USUARIO.USU_NOME, MATERIAL.MAT_NOME, D.EMP_QTD, LOCAL.LOC_ABRV, D.EMP_DATA, D.EMP_DATAPREVDEV, D.USU_AUTEMPCODIGO FROM MATERIAL, LOCAL, USUARIO, (
//    SELECT LOCALMATERIAL.MAT_CODIGO, LOCALMATERIAL.LOC_CODIGO, C.EMP_QTD, C.EMP_DATA, C.EMP_DATAPREVDEV, C.USU_CODIGO, C.USU_AUTEMPCODIGO FROM LOCALMATERIAL, (
//   	 SELECT * FROM (
//   		 SELECT A.LOCMAT_CODIGO, A.EMP_QTD, A.EMP_DATA, A.EMP_DATAPREVDEV, A.USU_CODIGO, A.USU_AUTEMPCODIGO FROM (
//   			 SELECT * FROM EMPRESTIMO WHERE EMPRESTIMO.EMP_ISATIVO = 1
//   		 ) AS A
//   	 ) AS B
//    ) AS C
//WHERE LOCALMATERIAL.LOCMAT_CODIGO = C.LOCMAT_CODIGO
//) AS D
//WHERE MATERIAL.MAT_CODIGO = D.MAT_CODIGO AND LOCAL.LOC_CODIGO = D.LOC_CODIGO AND USUARIO.USU_CODIGO = D.USU_CODIGO";

    $qrRead = "SELECT D.EMP_CODIGO, USUARIO.USU_NOME, MATERIAL.MAT_NOME, D.EMP_QTD, LOCAL.LOC_ABRV, D.EMP_DATA, D.EMP_DATAPREVDEV, D.USU_AUTEMPCODIGO FROM MATERIAL, LOCAL, USUARIO, (
    SELECT LOCALMATERIAL.MAT_CODIGO, LOCALMATERIAL.LOC_CODIGO, C.EMP_QTD, C.EMP_DATA, C.EMP_DATAPREVDEV, C.USU_CODIGO, C.USU_AUTEMPCODIGO, C.EMP_CODIGO FROM LOCALMATERIAL, (SELECT * FROM EMPRESTIMO WHERE EMPRESTIMO.EMP_ISATIVO = 1) AS C
WHERE LOCALMATERIAL.LOCMAT_CODIGO = C.LOCMAT_CODIGO
) AS D
WHERE MATERIAL.MAT_CODIGO = D.MAT_CODIGO AND LOCAL.LOC_CODIGO = D.LOC_CODIGO AND USUARIO.USU_CODIGO = D.USU_CODIGO";

    $stRead = mysql_query($qrRead) or die('Erro ao ler em ' . $tabela . ' ' . mysql_error());
    $cField = mysql_num_fields($stRead);
    for ($y = 0; $y < $cField; $y++) {
        $names[$y] = mysql_field_name($stRead, $y);
    }
    for ($x = 0; $res = mysql_fetch_assoc($stRead); $x++) {
        for ($i = 0; $i < $cField; $i++) {
            $resultado[$x][$names[$i]] = $res[$names[$i]];
        }
    }
    if ($resultado != NULL) {
        for ($index = 0; $index < sizeof($resultado); $index++) {
            $nome = read('USUARIO', 'WHERE USU_CODIGO = ' . $resultado[$index]['USU_AUTEMPCODIGO']);
            $resultado[$index]['USU_AUTEMP'] = $nome[0]['USU_NOME'];
        }
        return $resultado;
    } else {
        
    }
}

/* * ***************************
  FUNÇÃO PARA CONTAR OS EMPRESTIMOS EM ABERTO DE TODOS OS USUÁRIOS
 * *************************** */

function conta_todos_emprestimos() {
    $resultado = consulta_todos_emprestimos();
    return sizeof($resultado);
}

function consulta_local_material($id_material) {
    $resultado = "";

    $qrRead = "SELECT
    	LOCAL.LOC_ABRV,
    	LOCALMATERIAL.LOCMAT_CODIGO,
    LOCALMATERIAL.LOCMAT_QUANTIDADE
FROM
    LOCAL,
    LOCALMATERIAL WHERE LOCALMATERIAL.MAT_CODIGO = " . $id_material . " AND
    LOCAL.LOC_CODIGO = LOCALMATERIAL.LOC_CODIGO";
    $stRead = mysql_query($qrRead) or die('Erro ao ler em ' . $tabela . ' ' . mysql_error());
    $cField = mysql_num_fields($stRead);
    for ($y = 0; $y < $cField; $y++) {
        $names[$y] = mysql_field_name($stRead, $y);
    }
    for ($x = 0; $res = mysql_fetch_assoc($stRead); $x++) {
        for ($i = 0; $i < $cField; $i++) {
            $resultado[$x][$names[$i]] = $res[$names[$i]];
        }
    }

    if ($resultado != NULL) {

        for ($index = 0; $index < sizeof($resultado); $index++) {
            $qtd = soma('EMPRESTIMO', 'EMP_QTD', 'EMPRESTIMO.LOCMAT_CODIGO =' . $resultado[$index]['LOCMAT_CODIGO'] . ' AND EMPRESTIMO.EMP_ISATIVO = 1');
            $resultado[$index]['QTD_EMPRESTADA'] = $qtd[0];
        }
        return $resultado;
    } else {
        
    }
}

function ler_materiais() {
    $resultado = read('MATERIAL');

    if ($resultado != NULL) {
        for ($index = 0; $index < sizeof($resultado); $index++) {
            $qtd = conta_qtd_total_material($resultado[$index]['MAT_CODIGO']);
            $resultado[$index]['QUANTIDADE'] = $qtd;
        }
        return $resultado;
    } else {
        
    }
}
?>


