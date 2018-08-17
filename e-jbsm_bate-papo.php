<?
$permissao = array("usuario", "administrador", "orientador", "bolsista");
include 'functions/permitir.php';

$inicio_consulta = "";
if (isset($_GET["inicio_consulta"])) {
    $inicio_consulta = $_GET["inicio_consulta"];
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Bate-papo para integrantes do e-jbsm</h3>

        <div class="alert alert-info">
            Bem vindo ao bate-papo para integrantes do e-jbsm.
            Este espaço é destinado a trocar comunicações, como avisos e lembretes, entre os membros.
            Para discussões mais pontuais, aconselhamos a utilização do fórum.
        </div>
        <h4>Nova mensagem</h4>

        <form action="controller/Controller.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
            <textarea class="form-control" id="htmlbox_silk_icon_set_blue" rows="5"
                      placeholder="mensagem..."
                      name="topico_mensagem" required=""></textarea>
                </div>
                <div class="col-md-4">
                    Para
                    <select name="topico_para" required class="form-control">
                        <option value="todos">Todos</option>
                        <?
                        $sql = "select * from ejbsm_usuario where ejbsm_usuario.permissao != 'usuario' and login != '$user_login' and status != 'Inativo';";
                        $qr = $link->query($sql);
                        while ($r = mysqli_fetch_object($qr)) {
                            ?>
                            <option value="<?= $r->login ?>"><? echo "$r->nome / $r->login"; ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-md-4"><br>
                    <button type="submit" class="btn btn-success btn-block" name="opcao" value="Enviar mensagem">
                        <span class="glyphicon glyphicon-send"></span>
                        Enviar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de mensagens abaixo</h3>
    </div>
</div>
<?
if ($inicio_consulta != "" and $inicio_consulta > 0)
    $sql = "select * from ejbsm_batepapo_mensagem order by id desc limit 10 offset $inicio_consulta;";
else
    $sql = "select * from ejbsm_batepapo_mensagem order by id desc limit 10;";

$qr = $link->query($sql);
$j = 0;
while ($r = mysqli_fetch_object($qr)) {
    $j++;
    ?>
    <div class="panel panel-default" id="primeiro_topico">
        <div class="panel-body">
            <font color="green"><b>Dia </b></font><? echo $r->data; ?>
            <font color="green"><b>as </b></font><? echo $r->hora; ?>
            <font color="green"><b>ID </b></font><? echo $r->id ?>
            <table class="table">
                <tr>
                    <td style="text-align: center; width: 7%;">
                        <?
                        Imagem($r->login, 50);
                        ?>
                        <? echo $r->login ?></b>
                    </td>
                    <td style="text-align: center; width: 5%;"><font color="green"><b>Para</b></font></td>
                    <td style="text-align: center; width: 7%;">
                        <?
                        Imagem($r->para, 50);
                        ?>
                        <?= $r->para ?>
                    </td>
                    <td style="width: 75%; margin-left: 30%;">
                        <div id='cssmenu'>
                            <ul>
                                <li class='active has-sub'>
                                    <a>
                                        <?= $r->mensagem ?><br><br>
                                    <span>
                                        <?
                                        $sql = "select id from ejbsm_batepapo_resposta where id_mensagem = $r->id;";
                                        $result = $link->query($sql) or die(mysqli_error($link));
                                        $contagem_mensagens = mysqli_num_rows($result);
                                        ?>
                                        <font color="green"
                                              style="margin-left: 10px;"><b>Respostas<span
                                                    class="badge"><?= $contagem_mensagens ?></span></b></font>
                                    </span>
                                    </a>
                                    <ul>
                                        <li class='has-sub'>
                                            <a>
                                                <?
                                                $sql_respostas = "select * from ejbsm_batepapo_resposta where id_mensagem = '$r->id' order by id asc limit 10;";
                                                $qr_respostas = $link->query($sql_respostas);
                                                while ($resposta = mysqli_fetch_object($qr_respostas)) { ?>
                                                    <table class="table">
                                                        <tr>
                                                            <td rowspan='2' style="width: 40px">
                                                                <?
                                                                Imagem($resposta->login, 50);
                                                                ?>
                                                            </td>
                                                            <td> dia <font
                                                                    color="green"><b><?php echo "$resposta->data"; ?> </b></font>
                                                            </td>
                                                            <td> as <font
                                                                    color="green"><b><?php echo "$resposta->hora"; ?></b></font>
                                                            </td>
                                                            <? if ($resposta->login == $user_login) { ?>
                                                                <td>
                                                                    <form action="controller/Controller.php" method="post">
                                                                        <input type="hidden"
                                                                               value="<?= $resposta->id ?>"
                                                                               name="id">
                                                                        <button type="submit" class="btn btn-danger"
                                                                                name="opcao"
                                                                                value="Apagar resposta"
                                                                                style="border-radius: 2px;">
                                                                            <span
                                                                                class="glyphicon glyphicon-remove"></span>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            <? } ?>
                                                        </tr>
                                                        <tr>
                                                            <td colspan='3'><font
                                                                    color='green'><b>diz: </b></font><?= $resposta->resposta ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                <? } ?>
                                            </a>
                                        </li>
                                    </ul>

                                    <ul>
                                        <li class='has-sub'>
                                            <a>
                                            <span>
                                                <form action="controller/Controller.php" method="post">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Responder
                                                                <textarea class="form-control" cols="80"
                                                                          placeholder="resposta..."
                                                                          name="topico_resposta"
                                                                          required=""></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" value="<?= $r->id ?>"
                                                                       name="id">
                                                                <button type="submit" class="btn btn-success"
                                                                        name="opcao"
                                                                        value="Enviar resposta">
                                                                    <span class="glyphicon glyphicon-send"></span>
                                                                    Enviar
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td>
                        <? if ($r->login == $user_login) { ?>
                            <form action="controller/Controller.php" method="post">
                                <button type="button" style="width: 100%;" class="btn btn-danger btn-block"
                                        data-toggle="modal"
                                        data-target="#myModal<?= $j ?>">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal<?= $j ?>" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Confirmar exclusão.</h4>
                                            </div>
                                            <div class="modal-body">
                                                <h3>Deseja mesmo excluir esta mensagem? (ID: <?= $r->id ?>)</h3>
                                                <h5>Ao excluir a mensagem todas as respotas também serão apagadas.</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Cancelar
                                                </button>
                                                <input type="hidden" value="<?=$r->id ?>" name="id">
                                                <input type="hidden" value="<?=$r->anexo?>" name="anexo">
                                                <button type="submit" value="Apagar mensagem" class="btn btn-danger"
                                                        name="opcao">

                                                    <span class="glyphicon glyphicon-remove"></span>
                                                    Apagar mensagem
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <? } else { ?>
                            <button class="btn btn-danger disabled">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        <? } ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <nav class="paginacao">
            <ul class="pagination">
                <?php
                if ($inicio_consulta != "" and $inicio_consulta != 0) {
                    ?>
                    <li>
                        <a href="e-jbsm_bate-papo.php?inicio_consulta=<?= $inicio_consulta - 10 ?>#primeiro_topico">&laquo;</a>
                    </li>
                <?php } ?>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?= 0 ?>#primeiro_topico">1</a></li>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?= 10 ?>#primeiro_topico">2</a></li>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?= 20 ?>#primeiro_topico">3</a></li>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?= 30 ?>#primeiro_topico">4</a></li>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?= 40 ?>#primeiro_topico">5</a></li>
                <li>
                    <a href="e-jbsm_bate-papo.php?inicio_consulta=<?= $inicio_consulta + 10 ?>#primeiro_topico">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
</div>