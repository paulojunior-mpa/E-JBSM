<?php

include 'e-jbsm_cabecalho.php';

$info = "";
$email = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
if (isset($_GET["email"])) {
    $email = $_GET["email"];
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
    <div class="col-md-6">
        <?
        list($largura, $altura) = getimagesize('arquivos_imagem_sistema/logo.png');
        $max = 245;
        $x = ($altura * $max) / $largura;
        echo "<img src='arquivos_imagem_sistema/logo.png' width='$max' height='$x'>";
        ?>
    </div>
    <div class="panel panel-default col-md-6" style="margin-top: 2%">
        <div class="panel-body" style="margin-bottom: 2%">
            <form action="controller/Controller_public.php" method="post">
                <table class="table">
                    <tr>
                        <td>Para redefinir sua senha insira o 'login' cadastrado no campo abaixo.</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="form-control" placeholder="insira aqui seu login" required=""
                                   name="login">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="opcao" id="opcao" value="<?=Constantes::REDEFINIR_SENHA?>">
                            <button class='btn btn-warning' type="submit">
                                <span class="glyphicon glyphicon-retweet"></span>
                                Redefinir senha
                            </button>
                        </td>
                    </tr>
                    <? if ($info == "nao") { ?>
                        <tr>
                            <td>
                                <div class="alert alert-danger" role="alert">Este login não está cadastrado</div>
                            </td>
                        </tr>
                    <? } elseif ($info == "enviada") { ?>
                        <tr>
                            <td>
                                <div class="alert alert-success" role="alert">
                                    Sua nova senha foi enviada para o seu e-mail!<br>
                                    Você pode altera-la para uma de sua preferência logando no sistema e acessando o
                                    seu
                                    perfil.<br>
                                    Verifique sua caixa de spans.
                                    <br><a href="index.php">Voltar ao login.</a>
                                </div>
                            </td>
                        </tr>
                    <? } ?>
                    <tr>
                        <td>
                            Caso o login inserido esteja cadastrado, sua nova senha será enviada para o e-mail
                            cadastrado em
                            instantes.
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>