<?
session_start();
$ok = false;
//////////////
if (isset($_SESSION["dono_sessao"])) {
    $user_hash = sha1($_SESSION['user_permissao'] . $_SESSION['user_login']);
    $nome_sessao = sha1('seg' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $user_hash);
    if ($_SESSION["dono_sessao"] == $nome_sessao) {
        foreach ($permissao as $p) {
            if ($_SESSION['user_permissao'] == $p) {
                $user_login = $_SESSION['user_login'];
                $user_permissao = $_SESSION['user_permissao'];

                if(include 'connection/Connection.php'){
                    include 'e-jbsm_cabecalho.php';
                    include "forum_menu_lateral_.php";
                }else{
                    include "../connection/Connection.php";
                }
                $ok = true;
                break;
            }
        }
        if(!$ok){
            logout();
        }
    } else {
        logout();
    }
} else {
    logout();
}
function logout()
{
    session_destroy();
    header('location:index.php');
}

?>