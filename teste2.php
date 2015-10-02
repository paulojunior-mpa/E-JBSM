<?
include 'Service/Conexao.php';
include 'e-jbsm_cabecalho.php';

$arrayPlantas = file_get_contents("http://localhost:82/e-jbsm/webservice.php?usuario=willian&operacao=plantas");
$arrayPlantas = json_decode($arrayPlantas, true);

foreach($arrayPlantas as $planta){
    echo $planta['genero'];
    echo "<hr>";
}


?>