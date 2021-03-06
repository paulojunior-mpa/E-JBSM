<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 25/10/2015
 * Time: 11:14
 */

function distance($lat1, $lon1, $lat2, $lon2)
{

    $lat1 = deg2rad($lat1);
    $lat2 = deg2rad($lat2);
    $lon1 = deg2rad($lon1);
    $lon2 = deg2rad($lon2);

    $dist = (6371 * acos(cos($lat1) * cos($lat2) * cos($lon2 - $lon1) + sin($lat1) * sin($lat2)));
    $dist = number_format($dist, 3, '.', '');
    return $dist;
}
function checkImei($link, $user_login, $user_imei){

    // starta a inser��o de novo usu�rio
    $sql_user_insert = null;
    $sql_user_update = null;

    if ($user_login) {
        //seleciona um usu�rio pelo login
        $sql_user = "select * from ejbsm_imei where login = '$user_login'";
        $result = $link->query($sql_user) or die(mysqli_error($link));

        // se retornar usu�rio
        if ($user = mysqli_fetch_object($result)) {
            // atualiza a data pelo login
            $sql_user_update = "update ejbsm_imei set data = now(), imei = $user_imei where login = '$user_login';";
        } //sen�o insere novo usu�rio
        else {
            $sql_user_insert = "insert into ejbsm_imei(login, imei, data) values('$user_login', '$user_imei', now());";
        }
    } else {
        //seleciona um usu�rio pelo imei
        $sql_user = "select * from ejbsm_imei where imei = '$user_imei'";
        $result = $link->query($sql_user) or die(mysqli_error($link));

        // se retornar usu�rio
        if ($user = mysqli_fetch_object($result)) {
            // atualiza a data pelo imei
            $sql_user_update = "update ejbsm_imei set data = now() where imei = '$user_imei';";
        } //sen�o insere novo usu�rio
        else {
            $sql_user_insert = "insert into ejbsm_imei(login, imei, data) values('', '$user_imei', now());";
        }
    }
    if($sql_user_update)
        $link->query($sql_user_update);
    else
        $link->query($sql_user_insert);

    //selecionar a chave primaria da tabela imei do usu�rio
    $sql = "select id_imei from ejbsm_imei WHERE imei = $user_imei";
    $result = $link->query($sql);
    $id_imei = mysqli_fetch_object($result);

    //se a lista de recomenda��o do usu�rio esta vasia

    $sql = "select * from ejbsm_recomendacao WHERE id_imei = $id_imei->id_imei";
    $result = $link->query($sql);

    if(mysqli_num_rows($result)<=0){
        //vamos inserir em sua lista plantas mais acessadas e recomendalas

        //seleciona as plantas mais acessadas
        $sql = "select * from ejbsm_planta ORDER BY visualizada DESC limit 5";
        $result = $link->query($sql) or die(mysqli_error($link));
        while($plant = mysqli_fetch_object($result)){
            $sql = "insert into ejbsm_recomendacao(id_imei, id_planta, data) values($id_imei->id_imei, $plant->id, now())";
            $link->query($sql) or die(mysqli_error($link));
        }
    }

    return;
}
function checkPlanta($planta){

    if(empty($planta->nome_popular)){
        $planta->nome_popular = "n�o definido.";
    }
    if(empty($planta->especie)){
        $planta->especie = "n�o definido.";
    }
    if(empty($planta->genero)){
        $planta->genero = "n�o definido.";
    }
    if(empty($planta->familia)){
        $planta->familia = "n�o definido.";
    }
    if(empty($planta->descricao)){
        $planta->descricao = "n�o definido.";
    }
    if(empty($planta->origem)){
        $planta->origem = "n�o definido.";
    }
    if(empty($planta->exotica)){
        $planta->exotica = "n�o definido.";
    }
    if(empty($planta->florescimento_inicio) or $planta->florescimento_inicio == '0000-00-00'){
        $planta->florescimento = "n�o definido.";
    }else{
        $planta->florescimento = "de $planta->florescimento_inicio at� ";
    }
    if(empty($planta->florescimento_fim) or $planta->florescimento_fim == '0000-00-00'){
        $planta->florescimento = "n�o definido.";
    }else{
        $planta->florescimento.= " $planta->florescimento_fim";
    }

    return $planta;
}