<?
$permissao = array("usuario", "administrador", "orientador", "bolsista");
include 'functions/permitir.php';

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel-body">
    <? include 'forum_texto.php'; ?>
    <h3>Pesquisas personalizadas de tópicos</h3>
    <? include 'forum_caixa _pesquisa_.php'; ?>
    <h3>Cadastro de novo tópico</h3>
    <form action="controller/Forum_Controller.php" method="post" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <td style="width:30%;">Área / Subárea
                    <select name="area_subarea" class="form-control">
                        <?php
                        $sql = "select * from ejbsm_forum_area where status = 'ativa';";
                        $qr = $link->query($sql) or die(mysqli_error($link));
                        while ($area = mysqli_fetch_object($qr)) {
                            $sql2 = "select * from ejbsm_forum_subarea where id_area = '$area->id' and status = 'ativa'";
                            $qr2 = $link->query($sql2) or die(mysqli_error($link));
                            while ($subarea = mysqli_fetch_object($qr2)) {
                                ?>
                                <option
                                    value="<?= $area->id ?> / <?= $subarea->id ?>"><?php echo $area->nome ?>
                                    / <?php echo $subarea->nome ?></option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <td colspan="2">Assunto
                    <input type="text" class="form-control" name="assunto"
                           placeholder="este será o título do seu tópico"
                           required="" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td colspan="2">Mensagem
                    <textarea class="form-control" cols="80" rows="6" name="mensagem" placeholder="sua mensagem..."
                              required=""></textarea>
                </td>
            </tr>
            <tr>
                <td>Inserir anexo
                    <input type="file" class="form-control" name="anexo">
                </td>
                <td><br>
                    <button type="submit" class="btn btn-success" name="opcao" value="Cadastrar tópico">
                        <span class="glyphicon glyphicon-save"></span>
                        Cadastrar tópico
                    </button>
                </td>
            </tr>
        </table>
    </form>
    <!-- CADASTRO DE ÁREA -->
    <? if ($user_permissao == "bolsista" or $user_permissao == "administrador" or $user_permissao == "orientador") { ?>
        <h3>Cadastro de área</h3>
        <?php if ($info == "area_cadastrada") { ?>
            <div class="alert alert-success" role="alert">Área cadastrada com sucesso!</div>
        <?php }
        if ($info == "area_ja_cadastrada") { ?>
            <div class="alert alert-warning" role="alert">Área com mesmo nome já existe!</div>
        <?php } ?>
        <form action="controller/Forum_Controller.php" method="post">
            <table class="table">
                <tr>
                    <td>Nome da nova área
                        <input type="text" class="form-control" name="nome" placeholder="Nome da nova área"
                               required="">
                    </td>
                </tr>
                <tr>
                    <td>Descrição da nova área
                        <textarea class="form-control" cols="80" name="descricao" placeholder="Descrição da nova área"
                                  required=""></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" class="btn btn-success" name="opcao" value="Cadastrar area">
                            <span class="glyphicon glyphicon-save"></span>
                            Cadastrar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <!-- CADASTRO DE SUBÁREA -->
        <h3>Cadastro de subárea</h3>
        <?php if ($info == "subarea_cadastrada") { ?>
            <div class="alert alert-success" role="alert">Subárea cadastrada com sucesso!</div>
        <?php }
        if ($info == "subarea_ja_cadastrada") { ?>
            <div class="alert alert-success" role="alert">Subárea com mesmo nome já existe!</div>
        <?php } ?>
        <form action="controller/Forum_Controller.php" method="post">
            <table class="table">
                <tr>
                    <td style="width: 30%">Slecione a área
                        <select name="id_area" class="form-control" required="">
                            <?php
                            $sql = "select id, nome from ejbsm_forum_area  where status = 'ativa';";
                            $exec = $link->query($sql) or die(mysqli_error($link));
                            while ($area = mysqli_fetch_object($exec)) {
                                ?>
                                <option value="<?= $area->id ?>"><?php echo $area->nome ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>Nome da nova subárea
                        <input type="text" class="form-control" name="nome" placeholder="Nome da nova subárea"
                               required="">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Descrição da nova subárea
                            <textarea class="form-control" cols="80" name="descricao"
                                      placeholder="Descrição da nova subárea"
                                      required=""></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-success" name="opcao" value="Cadastrar subárea">
                            <span class="glyphicon glyphicon-save"></span>
                            Cadastrar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    <? } ?>
</div>