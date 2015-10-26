<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 25/10/2015
 * Time: 11:08
 */
//ID foi setado?
if (isset($_GET['id'])) {
    //ID na� est� nulo nem vazio?
    if (!empty($_GET["id"])) {
        //  limpa ID da planta de poss�veis coment�rios
        $plant_id = htmlspecialchars($_GET["id"]);


        //imei foi setado?
        if (isset($_GET['imei'])) {
            // Imei n�o est� nulo nem vazio?
            if (!empty($_GET["imei"])) {
                // limpa imei
                $user_imei = htmlspecialchars($_GET['imei']);

                $user_login = null;

                // Usu�rio foi setado?
                if (isset($_GET['login'])) {
                    // Usu�rio n�o est� nulo nem vazio?
                    if (!empty($_GET["login"])) {
                        // limpa usu�rio
                        $user_login = htmlspecialchars($_GET['login']);
                    }
                }

                checkImei($link, $user_login, $user_imei);

                //USU�RIO VERIFICADO E ATUALIZADO, AGORA VAMOS A PLANTA

                $sql_planta = "select * from ejbsm_planta WHERE id = $plant_id";
                $result = $link->query($sql_planta);
                //se retornar uma planta
                if ($plant = mysqli_fetch_object($result)) {

                    //atualiza a planta
                    $sql = "update ejbsm_planta set visualizada = (visualizada+1), ult_visualizada = now() where id = $plant_id";
                    $link->query($sql);

                    // remove a imagem da planta
                    unset($plant->img);

                    //hora de atualiza a lista de recomenda��o do usu�rio

                    //primeiro selecionar a chave primaria da tabela imei do usu�rio
                    $sql = "select id_imei from ejbsm_imei WHERE imei = $user_imei";
                    $result = $link->query($sql);
                    $id_imei = mysqli_fetch_object($result);

                    //ficamos apenas com o inteiro descartando o objeto
                    $id_imei = $id_imei->id_imei;

                    //verificar se a planta j� est� na lista do usu�rio
                    $sql_list_recomendation = "select * from ejbsm_recomendacao WHERE id_imei = $id_imei AND id_planta = $plant_id";
                    $result_list_recomendation = $link->query($sql_list_recomendation);

                    //se n�o est�
                    if (mysqli_num_rows($result_list_recomendation) == 0) {

                        //verificar se o numero de plantas na lista j� nao esta esgotado
                        $sql_list_recomendation = "select * from ejbsm_recomendacao WHERE id_imei = $id_imei ";
                        $result_list_recomendation = $link->query($sql_list_recomendation);

                        //se maior que o limite
                        if (mysqli_num_rows($result_list_recomendation) >= 20) {

                            //seleciona planta mais antiga
                            $sql = "SELECT * from ejbsm_recomendacao WHERE id_imei = $user_imei ORDER BY DATA ASC limit 1";
                            $result = $link->query($sql) or die(mysqli_error($link));
                            $r_a = mysqli_fetch_object($result);
                            $r_a = $r_a->id_recomendacao;


                            //insere a planta visitada no lugar da mais antiga na lista
                            $sql_update_list = "update ejbsm_recomendacao set id_planta = $plant_id, data = now() WHERE id_recomendacao = $r_a";
                            $link->query($sql_update_list) or die(mysqli_error($link));
                            exit;
                        } else {

                            //insere a nova planta na lista
                            $sql_insert_list = "insert into ejbsm_recomendacao(id_imei, id_planta, data) values($id_imei, $plant_id, now())";
                            $link->query($sql_insert_list);
                        }
                    }
                    //se est�, atualiza a data
                    else{
                        $sql_update_list = "update ejbsm_recomendacao set data = now() WHERE id_imei = $id_imei AND id_planta = $plant_id";
                        $link->query($sql_update_list);
                    }
                    $distancia = "indispon�vel";
                    if (isset($_GET['lat'])) {
                        if (isset($_GET['long'])) {
                            if (!empty($_GET['lat']) AND !empty($_GET['long'])) {
                                $lat_user = $_GET['lat'];
                                $long_user = $_GET['long'];

                                if (!empty($plant->latitude) AND !empty($plant->longitude)) {
                                    $distancia = distance($lat_user, $long_user, $plant->latitude, $plant->longitude);
                                }
                            }
                        }
                    }
                    $plant->distancia = $distancia;
                    $json =  json_encode($plant);
                    echo $json;
                } //senao informa ao usu�rio
                else {
                    echo "PLANTA null";
                }
            }
        }
    }
}
exit;