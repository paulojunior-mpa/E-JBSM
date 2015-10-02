<?php
if (isset($_GET["operacao"])) {
    if ($_GET["operacao"] != "" AND $_GET["operacao"] != null) {
        $operacao = htmlspecialchars($_GET["operacao"]);
        $link = new mysqli("localhost", "jbsm", "santo1981", "JBSM");
        switch ($operacao) {
            case "id":
                if (isset($_GET['id'])) {
                    if (!empty($_GET["id"])) {

                        $id = htmlspecialchars($_GET["id"]);

                        if (isset($_GET['usuario'])) {
                            if ($_GET["usuario"] != "" AND $_GET["usuario"] != null) {
                                $usuario = $_GET['usuario'];
                                $sql = "select * from ejbsm_imei where login = '$usuario'";
                                $result = $link->query($sql) or die(mysqli_error($link));
                                if ($usuarioObj = mysqli_fetch_object($result)) {
                                    $sql = "update ejbsm_imei set data = now() where login = '$usuario';";
                                    $sql2 = "select id_imei from ejbsm_imei where login = '$usuario'";
                                } else {
                                    $sql = "select * from ejbsm_imei where imei = '$usuario'";
                                    $result = $link->query($sql) or die(mysqli_error($link));
                                    if ($imei = mysqli_fetch_object($result)) {
                                        $sql = "update ejbsm_imei set data = now() where imei = '$usuario';";
                                    } else {
                                        $sql = "insert into ejbsm_imei(imei, login, data) VALUE ('$usuario', '$usuario', now())";
                                    }
                                    $sql2 = "select id_imei from ejbsm_imei where imei = '$usuario'";
                                }

                                $link->query($sql) or die(mysqli_error($link));

                                $result = $link->query($sql2);
                                $linha = mysqli_fetch_object($result);
                                $id_imei_inserido = $linha->id_imei;

                                $sql = "update ejbsm_planta set visualizada = (visualizada+1), ult_visualizada = now()";
                                $link->query($sql);
                                $sql = "select * from ejbsm_planta where id = $id";
                                $result = $link->query($sql);
                                if ($planta = mysqli_fetch_object($result)) {

                                    unset($planta->img);

                                    $sql = "select * from ejbsm_recomendacao where id_imei = '$id_imei_inserido' AND id_planta = '$id'";
                                    $result_planta = $link->query($sql);
                                    if (mysqli_num_rows($result_planta) <= 0) {
                                        $sql = "select * from ejbsm_recomendacao where id_imei = '$id_imei_inserido'";
                                        $result_recomendacao = $link->query($sql);

                                        if (mysqli_num_rows($result_recomendacao) < 5) {
                                            $sql = "insert into ejbsm_recomendacao(id_imei, id_planta, data) VALUES('$id_imei_inserido', '$id', now());";
                                            $link->query($sql);
                                        } else {
                                            $sql = "select * from ejbsm_recomendacao where data in(SELECT min(data) as data from ejbsm_recomendacao WHERE id_imei = '$id_imei_inserido') AND id_imei = '$id_imei_inserido'";
                                            $result = $link->query($sql);
                                            $menor_data = mysqli_fetch_object($result);
                                            $sql = "update ejbsm_recomendacao set data = now(), id_planta = '$id' WHERE id_recomendacao = $menor_data->id_recomendacao";
                                            $link->query($sql);
                                        }
                                    }
                                    $distancia = "Indisponível";
                                    if(isset($_GET['lat'])){
                                        if(isset($_GET['long'])){
                                            if(!empty($_GET['lat']) AND !empty($_GET['long'])){
                                                $lat_user = $_GET['lat'];
                                                $long_user = $_GET['long'];

                                                if(!empty($planta->latitude) AND !empty($planta->longitude)){
                                                    $distancia = distancia($lat_user,$long_user, $planta->latitude,$planta->longitude);
                                                }
                                            }
                                        }
                                    }
                                    $json = json_encode(array(
                                        'distancia' => $distancia,
                                        'planta' => $planta));
                                    echo $json;
                                    exit;
                                } else {
                                    echo "ID inexistente.";
                                }

                            } else {
                                echo "USUARIO null.";
                            }
                        } else {
                            echo "USUARIO no.";
                            exit;
                        }
                    } else {
                        echo "ID null.";
                    }
                } else {
                    echo "ID no.";
                }
                break;

            case "login":
                if (isset($_GET['login']) AND isset($_GET['senha'])) {
                    if (!empty($_GET["login"]) AND !empty($_GET["senha"])) {
                        $login = htmlspecialchars($_GET['login']);
                        $senha = htmlspecialchars($_GET['senha']);

                        $sql = "select * from ejbsm_usuario where login = '$login'";
                        $result = $link->query($sql) or die(mysqli_error($link));
                        if ($usuario = mysqli_fetch_object($result)) {
                            if ($usuario->senha == $senha) {
                                $json = json_encode($usuario);
                                echo $json;
                            } else {
                                echo "SENHA incorreta.";
                            }
                        } else {
                            echo "LOGIN incorreto.";
                        }
                    } else {
                        echo "LOGIN SENHA null.";
                    }
                } else {
                    echo "LOGIN SENHA no";
                }
                break;

            case "plantas":
                if (isset($_GET['usuario'])) {
                    if (!empty($_GET["usuario"])) {

                        $usuario = htmlspecialchars($_GET['usuario']);

                        $arrayPlantas = new ArrayObject();


                        $sql = "select * from ejbsm_imei where login = '$usuario' OR imei = '$usuario'";
                        $result = $link->query($sql) or die(mysqli_error($link));
                        if ($imei = mysqli_fetch_object($result)) {
                            $sql = "update ejbsm_imei set data = now() where id_imei = '$imei->id_imei';";
                        } else {
                            $sql = "insert into ejbsm_imei(imei, login, data) VALUE ('$usuario', '$usuario', now())";
                        }
                        $link->query($sql);
                        $sql = "select id_imei from ejbsm_imei where imei = '$usuario'";
                        $result = $link->query($sql);
                        $linha = mysqli_fetch_object($result);
                        $imei = $linha->id_imei;

                        $sql = "select * from ejbsm_recomendacao WHERE id_imei = '$imei'";
                        $result = $link->query($sql);
                        while ($recomendacao = mysqli_fetch_object($result)) {
                            $sql2 = "select * from ejbsm_planta WHERE id = $recomendacao->id_planta";
                            $result2 = $link->query($sql2);
                            $planta = mysqli_fetch_object($result2);
                            $sql2 = "select * from ejbsm_planta where especie = '$planta->especie' and familia = '$planta->familia' and genero = '$planta->genero' and id != '$planta->id' limit 1";
                            $result2 = $link->query($sql2);
                            $planta = mysqli_fetch_object($result2);
                            $i = true;
                            foreach ($arrayPlantas as $p) {
                                if ($p == $planta) {
                                    $i = false;
                                }
                            }
                            if ($i AND count($arrayPlantas) < 3) {
                                $arrayPlantas->append($planta);
                            }
                        }
                        echo json_encode(array(
                            'usuario' => $usuario,
                            'plantas' => $arrayPlantas
                        ));
                    } else {
                        echo "USUARIO null.";
                    }
                } else {
                    echo "USUARIO no.";
                }
                break;

            case 'filtro':

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
                            $arrayPlantas->append($planta);
                        }else{
                            echo json_encode(array(
                                'plantas' => $arrayPlantas
                            ));
                            break;
                        }
                    }
                    $i=true;
                }
        }
    } else {
        echo "OPERACAO null.";
    }
} else {
    echo "OPERACAO no.";
}
function distancia($lat1, $lon1, $lat2, $lon2) {

    $lat1 = deg2rad($lat1);
    $lat2 = deg2rad($lat2);
    $lon1 = deg2rad($lon1);
    $lon2 = deg2rad($lon2);

    $dist = (6371 * acos( cos( $lat1 ) * cos( $lat2 ) * cos( $lon2 - $lon1 ) + sin( $lat1 ) * sin($lat2) ) );
    $dist = number_format($dist, 3, '.', '');
    return $dist;
}
?>