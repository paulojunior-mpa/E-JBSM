<?

include 'e-jbsm_cabecalho.php';
$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
} elseif (isset($_COOKIE["login_e-jbsm"]) and isset($_COOKIE["senha_e-jbsm"])) {
    if ($_COOKIE["login_e-jbsm"] != "" and $_COOKIE["senha_e-jbsm"] != "") {
        ?>
        <style>
            #form_login {
                visibility: hidden;
            }
        </style>
        <form action="controller/Controller_public.php" method="post" id="form_login">
            <input type="text" value="<?= $_COOKIE["login_e-jbsm"] ?>" name="user_login">
            <input type="text" value="<?= $_COOKIE["senha_e-jbsm"] ?>" name="user_senha">
            <input type="hidden" value="sim" name="sha1">
            <input type="hidden" name="opcao" value="Logar">
            <input type="submit" name="opcao" value="Logar">
        </form>
        <script>
            document.getElementById("form_login").submit();
        </script>
        <?
    }
}
?>
<style>
    #tela {
        width: 100%;
        margin-left: 0%;
    }
</style>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-7" style="font-size: 15px">
            Bem vindo(a) ao sistema de gerencia do Jardim Botânico da Universidade Federal de Santa Maria.
        </div>
        <div class="col-md-offset-7" style="font-size: 40px">
            <?
            $sql = "select titulo from ejbsm_informacao";
            $row = mysqli_fetch_object($link->query($sql)) or die(mysqli_error($link));
            echo $row->titulo;
            ?>
        </div>
    </div>
</div>
<div class="row" style="background-image: url(arquivos_imagem_sistema/fundo.png);">
    <div class="col-md-5 col-md-offset-1">
        <?
        list($largura, $altura) = getimagesize('arquivos_imagem_sistema/logo.png');
        $max = 245;
        $x = ($altura * $max) / $largura;
        echo "<img src='arquivos_imagem_sistema/logo.png' width='$max' height='$x'>";
        ?>
    </div>
    <div class="panel panel-default col-md-6" style="margin-top: 2%">
        <div class="panel-body" style="margin-bottom: 2%">
            <? if ($info == "cadastrado") { ?>
                <div class="alert alert-success" role="alert">Usuario cadastrado! Utilize o login e senha informados
                    no cadastro.
                </div>
            <? } ?>
            <form class="form-horizontal" action="controller/Controller_public.php" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Login</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="user_login" id="inputEmail3" placeholder="login">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" name="user_senha" class="col-sm-2 control-label">Senha</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="user_senha" id="inputPassword3"
                               placeholder="senha">
                    </div>
                </div>
                <? if ($info == "login") { ?>
                    <div class="alert alert-danger" role="alert">Este login não está cadastrado</div>
                <? } ?>
                <? if ($info == "senha") { ?>
                <div class="alert alert-danger" role="alert">
                    A senha informada é invalida.
                    <script>
                        redefinir = confirm("Aviso aos usuários: o sistema de senhas foi alterado por questões de segurança " +
                            "Caso você ainda não tenha realizado o seguinte processo a partir de 12/06/2015 " +
                            "você deve redefinir sua senha para acessar o sistema.\n\n Clique em OK para redefinir ou Cancelar para tentar novamente.");
                        if (redefinir) {
                            window.location = "e-jbsm_redefinir_senha.php";
                        }
                    </script>
                    <?
                    if (isset($_GET["tentativas"])) {
                        $t = $_GET["tentativas"];
                        $r = (5 - $t);
                        if ($r <= 0) {
                            echo "Você errou 5 vezes seguidas, sua conta foi bloqueada, para desbloquear redefina sua senha";
                        } else {
                            echo "Voce errou $t vezes, ainda possui $r tentativas.";
                        }
                    }
                    } ?>
                </div>
                <? if ($info == "inativo") { ?>
                    <div class="alert alert-danger" role="alert">Esta conta foi desativada.</div>
                <? } ?>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-5">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="manter" value="sim"> Manter-me conectado
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <button class='btn btn-success' type="submit" name="opcao"
                                value="Logar">
                            <span class="glyphicon glyphicon-log-in"></span>
                            Entrar
                        </button>
                    </div>
                </div>
            </form>
            <div class="row col-md-12" style="margin-bottom: 2%">
                <div class="col-md-6">
                    Não possui uma conta?
                    <a href="e-jbsm_cadastro_usuario.php">
                        <button class='btn btn-info form-control' name="opcao" value="Cadastro">
                            <span class="glyphicon glyphicon-pencil"></span>
                            Clique aqui para se cadastrar.
                        </button>
                    </a>
                </div>
                <div class="col-md-6">
                    Esqueceu sua senha?
                    <a href="e-jbsm_redefinir_senha.php">
                        <button class="btn btn-warning">
                            <span class="glyphicon glyphicon-retweet"></span>
                            Clique aqui para redefinir.
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>