<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'e-jbsm_cabecalho.php';
$info = "";
if (isset($_GET["info"]))
    $info = $_GET["info"];
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
            <?php
            $sql = "select titulo from ejbsm_informacao";
            $row = mysqli_fetch_object($link->query($sql)) or die(mysqli_error($link));
            echo $row->titulo;
            ?>
        </div>
    </div>
</div>
<div class="row" style="background-image: url(arquivos_imagem_sistema/fundo.png);">
    <div class="col-md-5 col-md-offset-1">
        <?php
        list($largura, $altura) = getimagesize('arquivos_imagem_sistema/logo.png');
        $max = 245;
        $x = ($altura * $max) / $largura;
        echo "<img src='arquivos_imagem_sistema/logo.png' width='$max' height='$x'>";
        ?>
    </div>
    <div class="panel panel-default col-md-6" style="margin-top: 2%">
        <div class="panel-body" style="margin-bottom: 2%">
            <?php if (getParameter('info') == "cadastrado") { ?>
                <div class="alert alert-success" role="alert">Usuario cadastrado! Utilize o login e senha informados
                    no cadastro.
                </div>
            <?php } ?>
            <form class="form-horizontal" action="controller/PublicController.php" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Login</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="user_login" id="inputEmail3" placeholder="login">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Senha</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="user_senha" id="inputPassword3"
                               placeholder="senha">
                    </div>
                </div>
                <?php if (getParameter('info') == "login") { ?>
                    <div class="alert alert-danger" role="alert">Este login não está cadastrado</div>
                <?php } ?>
                <?php if (getParameter('info') == "senha") { ?>
                <div class="alert alert-danger" role="alert">
                    A senha informada é invalida.
                    <?php
                    if (!empty(getParameter("tentativas"))) {
                        $t = getParameter("tentativas");
                        $r = (5 - $t);
                        if ($r <= 0) {
                            echo "Você errou 5 vezes seguidas, sua conta foi bloqueada, para desbloquear redefina sua senha";
                        } else {
                            echo "Voce errou $t vezes, ainda possui $r tentativas.";
                        }
                    }
                    } ?>
                </div>
                <?php if (getParameter('info') == "inativo") { ?>
                    <div class="alert alert-danger" role="alert">Esta conta foi desativada.</div>
                <?php } ?>
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
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::LOGAR?>">
                        <button class='btn btn-success' type="submit">
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