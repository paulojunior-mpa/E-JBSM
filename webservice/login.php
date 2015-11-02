<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 25/10/2015
 * Time: 11:06
 */
if (isset($_GET['login']) AND isset($_GET['senha'])) {
    if (!empty($_GET["login"]) AND !empty($_GET["senha"])) {
        $login = htmlspecialchars($_GET['login']);
        $senha = sha1(htmlspecialchars($_GET['senha']));

        $sql = "select * from ejbsm_usuario where login = '$login'";
        $result = $link->query($sql) or die(mysqli_error($link));
        if ($usuario = mysqli_fetch_object($result)) {
            if ($usuario->senha == $senha){
                $json = json_encode($usuario);
                echo $json;
                exit;
            }
        }
    }
}
echo '{"login":null,"senha":null}';