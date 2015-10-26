<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 25/10/2015
 * Time: 11:07
 */
//imei foi setado?
if (isset($_GET['imei'])) {
    // Imei não está nulo nem vazio?
    if (!empty($_GET["imei"])) {
        // limpa imei
        $user_imei = htmlspecialchars($_GET['imei']);

        $user_login = null;

        // Usuário foi setado?
        if (isset($_GET['login'])) {
            // Usuário não está nulo nem vazio?
            if (!empty($_GET["login"])) {
                // limpa usuário
                $user_login = htmlspecialchars($_GET['login']);
            }
        }

        checkImei($link, $user_login, $user_imei);

        //USUÁRIO VERIFICADO E ATUALIZADO, AGORA VAMOS A RECOMENDAÇÃO


        //selecionar a chave primaria da tabela imei do usuário
        $sql = "select id_imei from ejbsm_imei WHERE imei = $user_imei";
        $result = $link->query($sql);
        $id_imei = mysqli_fetch_object($result);

        //array de plantas para serem recomendadas;
        $array_plants = array();
        $list_id_plants_base = null;

        // plantas do perfil
        $sql = "select * from ejbsm_recomendacao where id_imei = $id_imei->id_imei";
        $result = $link->query($sql);


        $i = 1;
        $j = mysqli_num_rows($result);
        //passa id das plantas para um array
        while ($list_base_recomendation = mysqli_fetch_object($result)) {
            if ($i != $j)
                $list_id_plants_base .= "$list_base_recomendation->id_planta, ";
            else
                $list_id_plants_base .= "$list_base_recomendation->id_planta";
            $i++;
        }

        $list_id_plants_base."<hr>";

        // plantas do perfil
        $sql = "select * from ejbsm_recomendacao where id_imei = $id_imei->id_imei ORDER BY data DESC limit 2";
        $result = $link->query($sql);
        while ($plant_base = mysqli_fetch_object($result)) {
            //seleciona os dados da planta base
            $sql = "select * from ejbsm_planta where id = $plant_base->id_planta";
            $r_p_b = $link->query($sql);
            $plant_base_ = mysqli_fetch_object($r_p_b);

            //seleciona uma planta parecida que nao esta na lista
            $sql = "select * from ejbsm_planta where id not in($list_id_plants_base) and(especie like '%$plant_base_->especie%' or ejbsm_planta.genero or '%$plant_base_->genero%' or familia like '%$plant_base_->familia%' or nome_popular like '$plant_base_->nome_popular')";
            $r_p_r = $link->query($sql);
            $plant_r = mysqli_fetch_object($r_p_r);

            unset($plant_r->img);
            array_push($array_plants, $plant_r);

        }

        //$json = json_encode($array_plants);
        //echo $json;


        //BUSCA DA TERCEIRA PLANTA POR PARTE DE OUTROS USUÁRIOS
        $sql = "select * from ejbsm_planta";
    }
}