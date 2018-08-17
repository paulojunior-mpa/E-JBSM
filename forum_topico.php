<?
$permissao = array("administrador", "orientador", "bolsista");
include 'functions/permitir.php';

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
if (isset($_GET["topico"])) {
    $topico_id = $_GET["topico"];
    $sql = "select visualizado from ejbsm_forum_topico where id = '$topico_id'";
    $topico = mysqli_fetch_object($link->query($sql));
    $vizualizados = explode(", ", $topico->visualizado);
    $j = 0;
    foreach ($vizualizados as $value) {
        if ($value == $user_login) {
            $j = 1;
            break;
        }
    }
    if ($j != 1) {
        if ($topico->visualizado == "")
            $novo_vizualizados = $topico->visualizado . $user_login;
        else
            $novo_vizualizados = $topico->visualizado . ", " . $user_login;
        $sql = "update ejbsm_forum_topico set visualizado = '$novo_vizualizados' where id = '$topico_id'";
        $link->query($sql);
    }
    $sql = "select * from ejbsm_forum_topico where id = '$topico_id'";
    $topico = mysqli_fetch_object($link->query($sql));
    ?>
    <div class="panel-body">
        <? include 'forum_texto.php'; ?>
        <div class="row">
            <div class="col-md-12">
                <font color="green">Visualizado por </font><? echo $topico->visualizado ?>.
            </div>
            <div class="col-md-12">
                <br>
                <?
                $sql = "select nome from ejbsm_forum_area where id = $topico->id_area";
                $pega_nome = mysqli_fetch_object($link->query($sql));
                $nome_area = $pega_nome->nome;
                $sql = "select nome from ejbsm_forum_subarea where id = $topico->id_subarea";
                $pega_nome = mysqli_fetch_object($link->query($sql));
                $nome_subarea = $pega_nome->nome;
                ?>
                <h3 class="panel-title"><font color="green"><b>Assunto: </b></font><? echo $topico->assunto ?></h3>
                <br>
                <font color="green"><b>Dia </b></font><? echo $topico->data; ?>
                <font color="green"><b>as </b></font><? echo $topico->hora; ?>
                <font color="green"><b>na área </b></font><a target="_blank"
                                                             href="forum_info.php?info=area&area=<?= $topico->id_area ?>"><? echo $nome_area ?></a>
                <font color="green"><b>e subárea </b></font><a target="_blank"
                                                               href="forum_info.php?info=subarea&subarea=<?= $topico->id_subarea ?>"><? echo $nome_subarea ?></a>
                <font color="green"><b>ID </b></font><? echo $topico->id ?>
                <br>
            </div>
            <div class="col-md-3">
                <?
                Imagem($topico->login, 100);
                $sql = "select * from ejbsm_usuario WHERE login = '$topico->login'";
                $result = $link->query($sql);
                $row = mysqli_fetch_object($result);
                ?>
                <br>
                <font color="green">Nome:</font> <? echo $row->nome; ?><br>
                <font color="green">Permissões:</font> <? echo $row->permissao; ?><br>
                <font color="green">E-mail:</font> <? echo $row->email; ?><br>
                <? if ($topico->login == $user_login or $user_permissao == "administrador") { ?>
                    <form action="controller/Forum_Controller.php" method="post">
                        <input type="hidden" value="<?= $topico->id ?>" name="id">
                        <input type="hidden" value="<?= $topico->anexo ?>" name="topico_anexo">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-block"
                                data-toggle="modal"
                                data-target="#myModal">
                            <span class="glyphicon glyphicon-remove"></span>
                            Deletar Tópico
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
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
                                        <h3>Deseja mesmo deletar este tópico?</h3>
                                        <h5>Ao deletar, todos os dados incluindo respostas e anexos também serão
                                            apagados.</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-danger" name="opcao"
                                                value="Deletar topico">
                                            <span class="glyphicon glyphicon-remove"></span>
                                            Deletar topico
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <? } ?>
            </div>
            <div class="col-md-9">
                <style>
                    #mensagem {
                        overflow: hidden;
                        text-overflow: clip;
                        margin-top: 20px;
                    }
                </style>
                <div id="mensagem">
                    <?
                    echo $mensagem = str_replace("\n", "<br />", $topico->mensagem) . "<br>";
                    ?>
                </div>
                <font color="green">Anexo:</font>
                <? if (file_exists("arquivos_forum_anexo/$topico->anexo")) {
                    chmod("arquivos_forum_anexo/$topico->anexo", 0755);
                    echo "<a target='_blank' href='arquivos_forum_anexo/$topico->anexo'><span>$topico->anexo</span></a>";
                } else {
                    echo "Sem anexo";
                }
                echo "<br>";
                ?>
            </div>
        </div>
        <h3>Responder</h3>

        <form action="controller/Forum_Controller.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td colspan="2">
                    <textarea class="form-control" style="width: 100%" cols="80" rows="6" placeholder="resposta..."
                              name="topico_resposta" required=""></textarea>
                        <h7 style="margin-left: 10px;">Anexar um arquivo</h7>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="file" class="form-control" name="anexo">
                    </td>
                    <td>
                        <input type="hidden" value="<?= $topico->id ?>" name="id">
                        <button type="submit" style="width: 100%" class="btn btn-success" name="opcao"
                                value="Cadastrar resposta">
                            <span class="glyphicon glyphicon-send"></span>
                            Enviar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <?
        $sql_respostas = "select * from ejbsm_forum_resposta where id_topico = '$topico->id' order by id desc;";
        $result = $link->query($sql_respostas) or die(mysqli_error($link));
        $contagem_respostas = mysqli_num_rows($result);
        echo "<h3 id='respostas' style='margin-left: 10px;'>Respostas ($contagem_respostas), mais recentes acima.</h3>";
        if ($info == "resposta_deletada") {
            echo "<div class='alert alert-warning' role = 'alert'>Sua resposta foi deletada</div>";
        }
        $j = 0;
        while ($resposta = mysqli_fetch_object($result)) {
            $j++; ?>
            <div class="row">
                <div class="col-md-12">
                    <?
                    echo "<hr>";
                    echo "<a target='_blank' href='forum_info.php?info=login&login=$resposta->login'>$resposta->login</a>";
                    echo " Respondeu";
                    echo " Dia $resposta->data";
                    echo " as $resposta->hora";
                    echo " ID $resposta->id";
                    echo "<hr>";
                    ?>
                </div>
                <div class="col-md-3">
                    <?
                    Imagem($resposta->login, 150);
                    $sql2 = "select * from ejbsm_usuario where login = '$resposta->login'";
                    $row = mysqli_fetch_object($link->query($sql2));
                    ?>
                    <br>
                    <font color="green">Nome: </font><? echo $row->nome; ?><br>
                    <font color="green">Permissões: </font><? echo $row->permissao; ?><br>
                    <font color="green">E-mail: </font><? echo $row->email; ?><br>
                    <? if ($resposta->login == $user_login or $user_permissao == "administrador") { ?>
                        <form action="controller/Forum_Controller.php" method="post">
                            <div class="modal fade" id="myModal<?= $j ?>" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span
                                                    aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Confirmação
                                                (ID: <?= $resposta->id ?>)</h4>
                                        </div>
                                        <div class="modal-body">
                                            <h3>Deseja mesmo deletar esta resposta?</h3>
                                            <h5>Ao deletar, o anexo também será excluído!</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <input type="hidden" value="<?= $resposta->id ?>"
                                                   name="id">
                                            <input type="hidden" value="<?= $topico->id ?>"
                                                   name="topico_id">
                                            <input type='hidden' value='<?= $resposta->anexo ?>'
                                                   name='resposta_anexo'>
                                            <button type="submit" class="btn btn-danger" name="opcao"
                                                    value="Deletar resposta">
                                                <span class="glyphicon glyphicon-remove"></span>
                                                Deletar resposta
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" style="width: 100%;" class="btn btn-danger btn-block"
                                    data-toggle="modal"
                                    data-target="#myModal<?= $j ?>">
                                <span class="glyphicon glyphicon-remove"></span>
                                Deletar Resposta
                            </button>
                        </form>
                    <? } ?>
                </div>
                <div class="col-md-9">
                    <div id="mensagem">
                        <?
                        echo $resposta->resposta = str_replace("\n", "<br />", $resposta->resposta) . "<br>";
                        ?>
                    </div>
                    <font color="green">Anexo:</font>
                    <?
                    if (file_exists("arquivos_forum_anexo/$resposta->anexo")) {
                        chmod("arquivos_forum_anexo/$resposta->anexo", 0755);
                        echo "<a target='_blank' href='arquivos_forum_anexo/$resposta->anexo'><span>$resposta->anexo</span></a>";
                    } else {
                        echo "Sem anexo";
                    }
                    ?>
                </div>
            </div>
        <? } ?>
    </div>
<?
} else {
    echo "nenhum tópico selecionado";
}
?>
