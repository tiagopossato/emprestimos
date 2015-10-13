<?php

require('conexao.php');
/* * ***************************
  GET HOME
 * *************************** */

function getHome() {
    $url = $_GET['url'];
    $url = explode('/', $url);
    $url[0] = ($url[0] == NULL ? 'index' : $url[0]);

    if (file_exists('tpl/' . $url[0] . '.php')) {
        require_once('tpl/' . $url[0] . '.php');
    } elseif (file_exists('tpl/' . $url[0] . '/' . $url[1] . '.php')) {
        require_once('tpl/' . $url[0] . '/' . $url[1] . '.php');
    } else {
        require_once('tpl/404.php');
    }
}

/* * ***************************
  SETA URL DA HOME
 * *************************** */

function setHome() {
    echo BASE;
}

/* * ***************************
  TRANFORMA STRING EM URL
 * *************************** */

function setUri($string) {
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
    $string = utf8_decode($string);
    $string = strtr($string, utf8_decode($a), $b);
    $string = strip_tags(trim($string));
    $string = str_replace(" ", "-", $string);
    $string = str_replace(array("-----", "----", "---", "--"), "-", $string);
    return strtolower(utf8_encode($string));
}

/* * ***************************
  FUNÇÃO DE CADASTRO NO BANCO
  Recebe uma tabela e um array de dados para inserir
 * *************************** */

function insert($tabela, array $datas) {
    $fields = implode(", ", array_keys($datas));
    $values = "'" . implode("', '", array_values($datas)) . "'";
    $qrCreate = "INSERT INTO {$tabela} ($fields) VALUES ($values)";
//    echo $qrCreate;
//    return;
    $stCreate = mysql_query($qrCreate) or die('Erro ao cadastrar em ' . $tabela . ' ' . mysql_error());

    if ($stCreate) {
        return true;
    }
}

/**
 * Executa uma função amrmazenada no banco de dados
 * @param type $funcao
 * @param array $datas
 * @return boolean
 */
function call($funcao, array $datas) {
    $fields = implode(", ", array_keys($datas));
    $values = "'" . implode("', '", array_values($datas)) . "'";
    $qrCreate = "CALL {$funcao} ($values)";
    echo $qrCreate;
    $stCreate = mysql_query($qrCreate) or die('Erro ao chamar ' . $funcao . ' ' . mysql_error());

    if ($stCreate) {
        return true;
    }
}

/* * ***************************
  FUNÇÃO DE LEITURA NO BANCO
 * *************************** */

function read($tabela, $condicao = NULL) {
    $resultado = "";

    $qrRead = "SELECT * FROM {$tabela} {$condicao}";
    //echo $qrRead . "<br>";
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
  FUNÇÃO DE EDIÇÃO NO BANCO
 * *************************** */

function update($tabela, array $datas, $condicao) {
    foreach ($datas as $fields => $values) {
        $campos[] = "$fields = '$values'";
    }

    $campos = implode(", ", $campos);
    $qrUpdate = "UPDATE {$tabela} SET $campos {$condicao}";
    echo $qrUpdate;
    echo "";
    $stUpdate = mysql_query($qrUpdate) or die('Erro ao atualizar em ' . $tabela . ' ' . mysql_error());

    if ($stUpdate) {
        return true;
    }
}

/* * ***************************
  FUNÇÃO DE DELETAR NO BANCO
 * *************************** */

function delete($tabela, $condicao) {
    $qrDelete = "DELETE FROM {$tabela} {$condicao}";
    $stDelete = mysql_query($qrDelete) or die('Erro ao deletar em ' . $tabela . ' ' . mysql_error());
}

/* * ***************************
  Paginação de resultados
 * *************************** */

function readPaginator($tabela, $condicao, $maximos, $link, $pag, $width = NULL, $maxlinks = 4) {
    //select dos dados
    $readPaginator = read("$tabela", "$condicao");
    //total de registros
    $total = count($readPaginator);
    //verifica se o total de registros é maior que o maximo que sera exibido em tela
    if ($total > $maximos) {
        //divide o total pelo valor maximo, retornando valor inteiro
        $paginas = ceil($total / $maximos);
        //verifica se existe width
        if ($width) {
            echo '<ul class="pagination" style="width:' . $width . '">';
            //se não deixa padrão
        } else {
            echo '<ul class="pagination">';
        }
        //primeira pagina
        echo '<li class="arrow"><a href="' . $link . '1">&laquo;</a></li>';
        for ($i = $pag - $maxlinks; $i <= $pag - 1; $i++) {
            if ($i >= 1) {
                echo '<a href="' . $link . $i . '">' . $i . '</a>';
            }
        }
        //paginas do meio
        //echo '<span class="current">'.$pag.'</span>';
        for ($i = $pag + 1; $i <= $pag + $maxlinks; $i++) {
            if ($i <= $paginas) {
                echo '<li><a href="' . $link . $i . '">' . $i . '</a></li>';
            }
        }
        //ultima pagina
        echo '<li class="arrow"><a href="' . $link . $paginas . '">&raquo;</a></li>';

        echo '</ul>
			<!-- /pagination -->';
    }
}

?>
