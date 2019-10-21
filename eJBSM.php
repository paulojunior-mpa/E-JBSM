<?php
/**
 * User: willian.manucello
 * Date: 17/08/2018
 * Time: 17:16
 */

class eJBSM
{
    /**
     * eJBSM constructor.
     */
    public function __construct()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        session_start();

        $this->import();

        $con = new Connection();
        $link = $con->getInstance();

        $user_permissao = isset($_SESSION['user_permissao']) ? $_SESSION['user_permissao'] : null;
        $user_login = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : null;

        $page = getParameter('ejbsm_uri');
        if (!empty($page)) {
            $page = explode('.php', $page)[0];
            if (file_exists($page . '.php')) {

                include $page . '.php';

                exit;
            }
        }
        header('location: /ejbsm/e-jbsm_login.php');
    }

    private function import()
    {
        include 'constantes/Constantes.php';
        include 'connection/Connection.php';
    }
}

function getParameter($key, $boolean = false)
{
    if (isset($_REQUEST[$key])) {
        $return = htmlspecialchars($_REQUEST[$key], ENT_QUOTES, 'UTF-8');
        return $boolean? (($return == 1 or $return == '1' or $return) ? 1 : 0) : $return;
    }
    return $boolean? 0 : '';
}


function logout()
{
    $previous_encoding = mb_internal_encoding();
    mb_internal_encoding('UTF-8');
    mb_internal_encoding($previous_encoding);
    $_SESSION["user_login"] = "";
    $_SESSION["user_senha"] = "";
    $_SESSION["user_permissao"] = "";
    $_SESSION["user_login"] = NULL;
    $_SESSION["user_senha"] = NULL;
    $_SESSION["user_permissao"] = NULL;
    setcookie("login_e-jbsm", null, time() + (86400 * 30), "/");
    setcookie("senha_e-jbsm", null, time() + (86400 * 30), "/");
    session_destroy();
    header('location: e-jbsm_login.php');
}

function isUserInRole($permissions, $include = true)
{
    $user_permissao = isset($_SESSION['user_permissao']) ? $_SESSION['user_permissao'] : null;
    if (!empty($user_permissao)) {
        foreach ($permissions as $p) {
            if ($user_permissao == $p) {

                $link = Connection::getInstance();

                $user_login = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : null;

                if($include) {
                    include 'e-jbsm_cabecalho.php';
                    include "forum_menu_lateral_.php";
                }
                return;
            }
        }
    }
    logout();
}

function imagem($login, $max)
{
    echo '<div id="imagemPerfilForum">';
    $x = 100;
    if (file_exists("arquivos_imagem_perfil/$login.jpg")) {
        chmod("arquivos_imagem_perfil/$login.jpg", 0755);
        list($largura, $altura) = getimagesize("arquivos_imagem_perfil/$login.jpg");
        $x = ($altura * $max) / $largura;
        echo "<a href='forum_info.php?info=login&login=$login'><img src='arquivos_imagem_perfil/$login.jpg' width='$max' height='$x'></a>";
    } else {
        echo "<a href='forum_info.php?info=login&login=$login'><img src='arquivos_imagem_perfil/user.png' width='$max' height='$x'></a>";
    }
    echo '</div>';
}

function imagemPlanta($img){
    if ($img!=null) {
        list($largura, $altura) = getimagesize("data:image/jpeg;base64,".base64_encode($img));
        if($largura != null and $altura != null) {
            $max = 80;
            $x = ($altura * $max) / $largura;
            echo "<img src='data:image/jpeg;base64," . base64_encode($img) . "' width='$max' height='$x'>";
        }
    }
    echo "<img src='arquivos_imagem_sistema/planta_default.png' width='80px' height='80'>";
}

function date_($date, $time = true)
{
    return date('d/m/Y' . ($time ? ' h:i:s' : ''), strtotime($date));
}

new eJBSM();
