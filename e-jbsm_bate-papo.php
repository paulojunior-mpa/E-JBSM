<?php
isUserInRole(array("usuario", "administrador", "orientador", "bolsista"));
;

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
            <br>Este espaço é destinado a trocar comunicações, como avisos e lembretes, entre os membros.
            <br>Para discussões mais pontuais, aconselhamos a utilização do fórum.
        </div>
        <h4>Nova mensagem</h4>

        <form action="controller/SystemController.php" method="post" enctype="multipart/form-data">
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
                        <?php
                        $sql = "select * from ejbsm_usuario where ejbsm_usuario.permissao != 'usuario' and login != '$user_login' and status != 0;";
                        $qr = $link->query($sql);
                        while ($r = mysqli_fetch_object($qr)) {
                            ?>
                            <option value="<?php echo  $r->login ?>"><?php echo "$r->nome / $r->login"; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4"><br>
                    <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::ENVIAR_MENSAGEM?>">
                    <button type="submit" class="btn btn-success btn-block" value="Enviar mensagem">
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
<?php
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
            <span style="color: green"><b>Dia </b></span><?php echo $r->data; ?>
            <span style="color: green"><b>as </b></span><?php echo $r->hora; ?>
            <span style="color: green"><b>ID </b></span><?php echo $r->id ?>
            <table class="table">
                <tr>
                    <td style="text-align: center; width: 7%;">
                        <?php
                        imagem($r->login, 50);
                        ?>
                        <?php echo $r->login ?></b>
                    </td>
                    <td style="text-align: center; width: 5%;"><span style="color: green"><b>Para</b></span></td>
                    <td style="text-align: center; width: 7%;">
                        <?php
                        imagem($r->para, 50);
                        ?>
                        <?php echo  $r->para ?>
                    </td>
                    <td style="width: 75%; margin-left: 30%;">
                        <div id='cssmenu'>
                            <ul>
                                <li class='active has-sub'>
                                    <a>
                                        <?php echo  $r->mensagem ?><br><br>
                                    <span>
                                        <?php
                                        $sql = "select id from ejbsm_batepapo_resposta where id_mensagem = $r->id;";
                                        $result = $link->query($sql) or die(mysqli_error($link));
                                        $contagem_mensagens = mysqli_num_rows($result);
                                        ?>
                                        <span style="color: green; margin-left: 10px;"><b>Respostas<span class="badge"><?php echo  $contagem_mensagens ?></span></b></span>
                                    </span>
                                    </a>
                                    <ul>
                                        <li class='has-sub'>
                                            <a>
                                                <?php
                                                $sql_respostas = "select * from ejbsm_batepapo_resposta where id_mensagem = '$r->id' order by id asc limit 10;";
                                                $qr_respostas = $link->query($sql_respostas);
                                                while ($resposta = mysqli_fetch_object($qr_respostas)) { ?>
                                                    <table class="table">
                                                        <tr>
                                                            <td rowspan='2' style="width: 40px">
                                                                <?php
                                                                imagem($resposta->login, 50);
                                                                ?>
                                                            </td>
                                                            <td> dia <span STYLE="color: green"><b><?php echo "$resposta->data"; ?> </b></span>
                                                            </td>
                                                            <td> as <span STYLE="color: green"><b><?php echo "$resposta->hora"; ?></b></span>
                                                            </td>
                                                            <?php if ($resposta->login == $user_login) { ?>
                                                                <td>
                                                                    <form action="controller/SystemController.php" method="post">
                                                                        <input type="hidden" value="<?php echo  $resposta->id ?>" name="id">
                                                                        <input type="hidden" value="<?php echo Constantes::APAGAR_RESPOSTA?>" name="opcao" id="opcao">
                                                                        <button type="submit" class="btn btn-danger" style="border-radius: 2px;">
                                                                            <span class="glyphicon glyphicon-remove"></span>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr>
                                                            <td colspan='3'><span STYLE="color: green"><b>diz: </b></span><?php echo  $resposta->resposta ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                <?php } ?>
                                            </a>
                                        </li>
                                    </ul>

                                    <ul>
                                        <li class='has-sub'>
                                            <form action="controller/SystemController.php" method="post">
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
                                                            <input type="hidden" value="<?php echo  $r->id ?>" name="id">
                                                            <input type="hidden" value="<?php echo Constantes::ENVIAR_RESPOSTA?>" name="opcao" id="opcao">
                                                            <button type="submit" class="btn btn-success">
                                                                <span class="glyphicon glyphicon-send"></span>
                                                                Enviar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td>
                        <?php if ($r->login == $user_login) { ?>
                            <form action="controller/SystemController.php" method="post">
                                <button type="button" style="width: 100%;" class="btn btn-danger btn-block"
                                        data-toggle="modal"
                                        data-target="#myModal<?php echo  $j ?>">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal<?php echo  $j ?>" tabindex="-1" role="dialog"
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
                                                <h3>Deseja mesmo excluir esta mensagem? (ID: <?php echo  $r->id ?>)</h3>
                                                <h5>Ao excluir a mensagem todas as respotas também serão apagadas.</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Cancelar
                                                </button>
                                                <input type="hidden" value="<?php echo $r->id ?>" name="id">
                                                <input type="hidden" value="<?php echo Constantes::APAGAR_MENSAGEM?>" name="opcao" id="opcao">
                                                <button type="submit" class="btn btn-danger">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                    Apagar mensagem
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php } else { ?>
                            <button class="btn btn-danger disabled">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
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
                        <a href="e-jbsm_bate-papo.php?inicio_consulta=<?php echo  $inicio_consulta - 10 ?>#primeiro_topico">&laquo;</a>
                    </li>
                <?php } ?>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?php echo  0 ?>#primeiro_topico">1</a></li>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?php echo  10 ?>#primeiro_topico">2</a></li>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?php echo  20 ?>#primeiro_topico">3</a></li>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?php echo  30 ?>#primeiro_topico">4</a></li>
                <li><a href="e-jbsm_bate-papo.php?inicio_consulta=<?php echo  40 ?>#primeiro_topico">5</a></li>
                <li>
                    <a href="e-jbsm_bate-papo.php?inicio_consulta=<?php echo  $inicio_consulta + 10 ?>#primeiro_topico">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
</div>