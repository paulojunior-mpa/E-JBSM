<?php
//Cadastra usuarios com permissões de adm, orient. e bolsist.
/**
 * @param $permissao
 * @param $link
 */
function cadastrarIntegrante($permissao, $link)
{
    $login = "";
    $senha = "";
    $nome = "";
    $id = "";
    $email = "";
    $fixo = "";
    $celular = "";
    $rg = "";
    $orgao = "";
    $cpf = "";
    $area = "";
    $subarea = "";
    $projeto = "";
    $bolsa = "";
    $conta = "";
    $tipo_conta = "";
    $banco = "";
    $agencia = "";

    if (isset($_POST["login"])) {
        $login = $_POST["login"];
    }
    if (isset($_POST["senha"])) {
        $senha = sha1($_POST["senha"]);
    }
    if (isset($_POST["nome"])) {
        $nome = $_POST["nome"];
    }
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
    }
    if (isset($_POST["fixo"])) {
        $fixo = $_POST["fixo"];
    }
    if (isset($_POST["celular"])) {
        $celular = $_POST["celular"];
    }
    if (isset($_POST["rg"])) {
        $rg = $_POST["rg"];
    }
    if (isset($_POST["orgao"])) {
        $orgao = $_POST["orgao"];
    }
    if (isset($_POST["cpf"])) {
        $cpf = $_POST["cpf"];
    }
    if (isset($_POST["area"])) {
        $area = $_POST["area"];
    }
    if (isset($_POST["subarea"])) {
        $subarea = $_POST["subarea"];
    }
    if (isset($_POST["projeto"])) {
        $projeto = $_POST["projeto"];
    }
    if (isset($_POST["bolsa"])) {
        $bolsa = $_POST["bolsa"];
    }
    if (isset($_POST["conta"])) {
        $conta = $_POST["conta"];
    }
    if (isset($_POST["tipo_conta"])) {
        $tipo_conta = $_POST["tipo_conta"];
    }
    if (isset($_POST["banco"])) {
        $banco = $_POST["banco"];
    }
    if (isset($_POST["agencia"])) {
        $agencia = $_POST["agencia"];
    }

    $sql = "INSERT INTO ejbsm_usuario(login, senha, nome, email, fixo, celular, status, permissao) VALUES ('$login', '$senha', '$nome', '$email', '$fixo', '$celular', 'Ativo', '$permissao');";
    $link->query($sql) or die(mysqli_error($link));

    $sql = "INSERT INTO ejbsm_integrante(login, id, cpf, rg, orgao, area, subarea, projeto, banco, conta, tipo_conta, agencia, bolsa) VALUES ('$login', '$id', '$cpf', '$rg', '$orgao', '$area', '$subarea', '$projeto', '$banco', '$conta', '$tipo_conta', '$agencia', '$bolsa');";
    $link->query($sql) or die(mysqli_error($link));
}

function deslogar($link)
{
    $previous_encoding = mb_internal_encoding();
    mb_internal_encoding('UTF-8');
    mb_internal_encoding($previous_encoding);
    mysqli_close($link);
    $_SESSION["user_login"] = "";
    $_SESSION["user_senha"] = "";
    $_SESSION["user_permissao"] = "";
    $_SESSION["user_login"] = NULL;
    $_SESSION["user_senha"] = NULL;
    $_SESSION["user_permissao"] = NULL;
    setcookie("login_e-jbsm", null, time() + (86400 * 30), "/");
    setcookie("senha_e-jbsm", null, time() + (86400 * 30), "/");
    session_destroy();
    header('location: ../index.php');
}