<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 25/10/2015
 * Time: 11:07
 */

$condicao = "AND";
if (isset($_GET['search'])) {
    if (!empty($_GET['search'])) {
        $condicao = "OR";
    }
}
$arrayPlantas = new ArrayObject();
$sql_final = "select * from ejbsm_planta where nome_popular != '' AND ";
$arrayCulunas = array('nome_popular', 'genero', 'familia', 'florescimento_inicio', 'florescimento_fim');

foreach ($arrayCulunas as $coluna) {
    if (isset($_GET["$coluna"])) {
        if (!empty($_GET["$coluna"])) {
            $valor = htmlspecialchars($_GET["$coluna"]);
            $sql_final .= "UPPER($coluna) like UPPER('%$valor%') $condicao ";
        }
    }
}
$sql_final .= " 1 = 1;";
$i = true;
$result = $link->query($sql_final);
while ($planta = mysqli_fetch_object($result)) {
    foreach ($arrayPlantas as $p) {
        if ($p == $planta) {
            $i = false;
        }
    }
    if ($i) {
        if (count($arrayPlantas) < 5) {
            array_push($arrayPlantas, $planta);
        } else {
            echo json_encode($arrayPlantas);
            break;
        }
    }
    $i = true;
}