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

    // starta a inserção de novo usuário
    $sql_user_insert = null;
    $sql_user_update = null;
    $user_fisrt_time = false;

    if ($user_login) {
        //seleciona um usuário pelo login
        $sql_user = "select * from ejbsm_imei where login = '$user_login'";
        $result = $link->query($sql_user) or die(mysqli_error($link));

        // se retornar usuário
        if ($user = mysqli_fetch_object($result)) {
            // atualiza a data pelo login
            $sql_user_update = "update ejbsm_imei set data = now(), imei = $user_imei where login = '$user_login';";
        } //senão insere novo usuário
        else {
            $user_fisrt_time = true;
            $sql_user_insert = "insert into ejbsm_imei(login, imei, data) values('$user_login', '$user_imei', now());";
        }
    } else {
        //seleciona um usuário pelo imei
        $sql_user = "select * from ejbsm_imei where imei = '$user_imei'";
        $result = $link->query($sql_user) or die(mysqli_error($link));

        // se retornar usuário
        if ($user = mysqli_fetch_object($result)) {
            // atualiza a data pelo imei
            $sql_user_update = "update ejbsm_imei set data = now() where imei = '$user_imei';";
        } //senão insere novo usuário
        else {
            $user_fisrt_time = true;
            $sql_user_insert = "insert into ejbsm_imei(login, imei, data) values('', '$user_imei', now());";
        }
    }
    if($sql_user_update)
        $link->query($sql_user_update);
    else
        $link->query($sql_user_insert);

    //selecionar a chave primaria da tabela imei do usuário
    $sql = "select id_imei from ejbsm_imei WHERE imei = $user_imei";
    $result = $link->query($sql);
    $id_imei = mysqli_fetch_object($result);

    //se é a primeira vez do usuário
    if($user_fisrt_time){
        //vamos inserir em sua lista plantas mais acessadas e recomendalas

        //seleciona as plantas mais acessadas
        $sql = "select * from ejbsm_planta ORDER BY visualizada DESC limit 3";
        $result = $link->query($sql) or die(mysqli_error($link));
        while($plant = mysqli_fetch_object($result)){

            $plant_id = $plant->id;

            $sql = "insert into ejbsm_recomendacao(id_imei, id_planta, data) values($id_imei, $plant_id, now())";
            $link->query($sql) or die(mysqli_error($link));
        }
    }

    return;
}