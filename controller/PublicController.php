<?php

if (getParameter('opcao') != null) {
    $opcao = getParameter("opcao");
    switch ($opcao) {
        case "":
            header('location: ../index.php');
            break;

        case Constantes::LOGAR:
            $user_login = getParameter("user_login");
            $user_senha = getParameter("user_senha");

            $encriptar = getParameter('encriptar', false);

            login($user_login, $user_senha, $link);
            break;

        case Constantes::CADASTRAR_USUARIO:

            $usuario['nome']=(htmlspecialchars($_POST["usuario_nome"], ENT_QUOTES, 'UTF-8'));
            $usuario['email']=(htmlspecialchars($_POST["usuario_email"], ENT_QUOTES, 'UTF-8'));
            $usuario['cidade']=(htmlspecialchars($_POST["usuario_cidade"], ENT_QUOTES, 'UTF-8'));
            $usuario['fixo']=(htmlspecialchars($_POST["usuario_fixo"], ENT_QUOTES, 'UTF-8'));
            $usuario['celular']=(htmlspecialchars($_POST["usuario_celular"], ENT_QUOTES, 'UTF-8'));
            $usuario['login']=(htmlspecialchars($_POST["usuario_login"], ENT_QUOTES, 'UTF-8'));
            $usuario['senha']=(htmlspecialchars($_POST["usuario_senha"], ENT_QUOTES, 'UTF-8'));

            $usuario_senha2 = htmlspecialchars($_POST["usuario_confirma_senha"], ENT_QUOTES, 'UTF-8');

            if ($usuario_senha2 != $usuario['senha']) {
                $usuario = json_encode($usuario);
                header("location: ../e-jbsm_cadastro_usuario.php?info=senha&usuario=$usuario");
            } else {
                $senha_encriptada = sha1($_POST["usuario_senha"]);
                $nome  = $usuario['nome'];
                $email  = $usuario['email'];
                $cidade  = $usuario['cidade'];
                $fixo  = $usuario['fixo'];
                $celular  = $usuario['celular'];
                $login  = $usuario['login'];

                $sql = "insert into ejbsm_usuario(login, nome, email, senha, cidade, celular, fixo, permissao, status) values"
                    . "('$login', '$nome', '$email', '$senha_encriptada', '$cidade', $celular, $fixo, 'usuario', 'Ativo');";

                $usuario = json_encode($usuario);

                $link->query($sql) or die(header("location: ../e-jbsm_cadastro_usuario.php?info=login&usuario=$usuario"));

                login($login, $_POST["usuario_senha"], $link);
            }
            break;

        case Constantes::REDEFINIR_SENHA:

            $login = htmlspecialchars($_POST["login"], ENT_QUOTES, 'UTF-8');

            $sql = "select senha, nome, email from ejbsm_usuario where login = '$login';";
            $linha = mysqli_fetch_object($link->query($sql));

            if ($linha->senha != "") {

                function Senha_randomica($tamanho)
                {
                    $alfabeto = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    $nova_senha = "";
                    for ($count = 0; $tamanho > $count; $count++) {
                        $nova_senha .= $alfabeto[rand(0, strlen($alfabeto) - 1)];
                    }
                    return $nova_senha;
                }

                $nova_senha = Senha_randomica(8);
                $senha_encriptada = sha1($nova_senha);

                $sql = "update ejbsm_usuario set senha = '$senha_encriptada', tentativas_login = 0 where login = '$login'";
                $link->query($sql) or die(mysqli_error($link));


                $headers = "Content-Type:text/html; charset=UTF-8\n";
                $headers .= "From: JBSM<adm.jsbm@gmail.com>\n";
                $headers .= "X-Sender: <adm.jbsm@gmail.com>\n";
                $headers .= "X-Mailer: PHP v" . phpversion() . "\n";
                $headers .= "X-IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
                $headers .= "Return-Path: <adm.jbsm@gmail.com>\n";
                $headers .= "MIME-Version: 1.0\n";
                $email_mensagem = "
	Olá $linha->nome, você solictou a redefinição de senha em nosso sistema com o login '$login'.<br>
	<b>Senha:</b> $nova_senha.<br>

	<strong> Descrição:</strong> Recuperação de senha do sistema de agendamentos do Jardim Botânico da Uiversidade Federal de Santa Maria.<br>

	<strong>Unidade:</strong> CCNE - Centro de Ciências Naturais e Exatas.<br>
	<strong>Telefone:</strong> (55)3220-8339 - ramal 222 ou 225. <br>
	<strong>Secretaria administrativa:</strong> Prédio 16 - CENTRO DE EDUCAÇÃO, sala 3131C <br>
	<br>
	";

                mail("$linha->email", "Nova mensagem", "$email_mensagem", $headers);
                header('location: ../e-jbsm_redefinir_senha.php?info=enviada');
            } else {
                header('location: ../e-jbsm_redefinir_senha.php?info=nao');
            }
            break;
    }
} else {
    header('location: ../index.php');
}

function login($user_login, $user_senha, $link){
    if ($user_login == "" || $user_senha == "")
        logout();

    $sql = "select * from ejbsm_usuario where login = '$user_login';";
    $user = mysqli_fetch_object($link->query($sql));

    if (isset($_REQUEST["sha1"])) {
        $user_senha_sha1 = $user_senha;
    } else {
        $user_senha_sha1 = sha1($user_senha);
    }

    if ($user->senha == $user_senha_sha1) {

        $_SESSION["user_login"] = $user_login;
        $_SESSION["user_permissao"] = $user->permissao;

        if ($user->status != 0) {
            if ($user->tentativas_login >= 5) {
                header("location: ../e-jbsm_login.php?info=senha&tentativas=$user->tentativas_login");
            } else {
                if (isset ($_POST["manter"])) {
                    setcookie("login_e-jbsm", $user->login, time() + (86400 * 30), "/");
                    setcookie("senha_e-jbsm", $user->senha, time() + (86400 * 30), "/");
                }
                $sql = "update ejbsm_usuario set  tentativas_login = 0 where login = '$user_login'";
                $link->query($sql) or die(mysqli_error($link));

                header('location: ../e-jbsm_home.php');
            }
        } else {
            header('location: ../e-jbsm_login.php?info=inativo');
        }

    } else if ($user->login == $user_login) {
        $sql = "update ejbsm_usuario set tentativas_login = tentativas_login+1 where login = '$user_login'";
        $link->query($sql) or die(mysqli_error($link));
        $sql = "select tentativas_login from ejbsm_usuario where login = '$user_login'";
        $result = $link->query($sql) or die(mysqli_error($link));
        $tentativas = mysqli_fetch_object($result);
        header("location: ../e-jbsm_login.php?info=senha&tentativas=$tentativas->tentativas_login");
    } else {
        session_destroy();
        header('location: ../index.php?info=login');
    }
}