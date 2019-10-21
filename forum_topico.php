<?php
isUserInRole(array("administrador", "orientador", "bolsista"));
;

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
if (isset($_GET["topico"])) {
    $topico_id = $_GET["topico"];
    $sql = "select visualizado from ejbsm_forum_topico where id = '$topico_id'";
    $topico = mysqli_fetch_object($link->query($sql));
    $visualizados = explode(", ", $topico->visualizado);
    $j = 0;
    foreach ($visualizados as $value) {
        if ($value == $user_login) {
            $j = 1;
            break;
        }
    }
    if ($j != 1) {
        if ($topico->visualizado == "")
            $novo_visualizados = $topico->visualizado . $user_login;
        else
            $novo_visualizados = $topico->visualizado . ", " . $user_login;
        $sql = "update ejbsm_forum_topico set visualizado = '$novo_visualizados' where id = '$topico_id'";
        $link->query($sql);
    }
    $sql = "select * from ejbsm_forum_topico where id = '$topico_id'";
    $topico = mysqli_fetch_object($link->query($sql));
    ?>
    <div class="panel-body">
        <?php include 'forum_texto.php'; ?>
        <div class="row">
            <div class="col-md-12">
                <span style="color: green">Visualizado por </span><?php echo $topico->visualizado ?>.
            </div>
            <div class="col-md-12">
                <br>
                <?php
                $sql = "select nome from ejbsm_forum_area where id = $topico->id_area";
                $pega_nome = mysqli_fetch_object($link->query($sql));
                $nome_area = $pega_nome->nome;
                $sql = "select nome from ejbsm_forum_subarea where id = $topico->id_subarea";
                $pega_nome = mysqli_fetch_object($link->query($sql));
                $nome_subarea = $pega_nome->nome;
                ?>
                <h3 class="panel-title"><span style="color: green"><b>Assunto: </b></span><?php echo $topico->assunto ?></h3> <br>
                <span style="color: green"><b>Dia </b></span><?php echo $topico->data; ?>
                <span style="color: green"><b>as </b></span><?php echo $topico->hora; ?>
                <span style="color: green"><b>na área </b></span><a target="_blank" href="forum_info.php?info=area&area=<?php echo $topico->id_area ?>"><?php echo $nome_area ?></a>
                <span style="color: green"><b>e subárea </b></span><a target="_blank" href="forum_info.php?info=subarea&subarea=<?php echo $topico->id_subarea ?>"><?php echo $nome_subarea ?></a>
                <span style="color: green"><b>ID </b></span><?php echo $topico->id ?>
                <br>
            </div>
            <div class="col-md-3">
                <?
                imagem($topico->login, 100);
                $sql = "select * from ejbsm_usuario WHERE login = '$topico->login'";
                $result = $link->query($sql);
                $row = mysqli_fetch_object($result);
                ?>
                <br>
                <span style="color: green">Nome:</span> <?php echo $row->nome; ?><br>
                <span style="color: green">Permissões:</span> <?php echo $row->permissao; ?><br>
                <span style="color: green">E-mail:</span> <?php echo $row->email; ?><br>
                <?php if ($topico->login == $user_login or $user_permissao == "administrador") { ?>
                    <form action="controller/ForumController.php" method="post">
                        <input type="hidden" value="<?php echo $topico->id ?>" name="id">
                        <input type="hidden" value="<?php echo $topico->anexo ?>" name="topico_anexo">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#myModal">
                            <span class="glyphicon glyphicon-remove"></span>
                            Deletar Tópico
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Confirmar exclusão.</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h3>Deseja mesmo deletar este tópico?</h3>
                                        <h5>Ao deletar, todos os dados incluindo respostas e anexos também serão apagados.</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar
                                        </button>
                                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::DELETAR_TOPICO?>">
                                        <button type="submit" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-remove"></span>
                                            Deletar topico
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
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
                    <?php
                    echo $mensagem = str_replace("\n", "<br />", $topico->mensagem) . "<br>";
                    ?>
                </div>
                <span style="color: green">Anexo:</span>
                <?php if (file_exists("arquivos_forum_anexo/$topico->anexo")) {
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

        <form action="controller/ForumController.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td colspan="2">
                        <textarea class="form-control" style="width: 100%" cols="80" rows="6" placeholder="resposta..." name="topico_resposta" required=""></textarea>
                        <h6 style="margin-left: 10px;">Anexar um arquivo</h6>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="file" class="form-control" name="anexo">
                    </td>
                    <td>
                        <input type="hidden" value="<?php echo $topico->id ?>" name="id">
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::CADASTRAR_RESPOSTA?>">
                        <button type="submit" style="width: 100%" class="btn btn-success">
                            <span class="glyphicon glyphicon-send"></span>
                            Enviar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <?php
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
                    <?php
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
                    <?php
                    imagem($resposta->login, 150);
                    $sql2 = "select * from ejbsm_usuario where login = '$resposta->login'";
                    $row = mysqli_fetch_object($link->query($sql2));
                    ?>
                    <br>
                    <span style="color: green">Nome: </span><?php echo $row->nome; ?><br>
                    <span style="color: green">Permissões: </span><?php echo $row->permissao; ?><br>
                    <span style="color: green">E-mail: </span><?php echo $row->email; ?><br>
                    <?php if ($resposta->login == $user_login or $user_permissao == "administrador") { ?>
                        <form action="controller/ForumController.php" method="post">
                            <div class="modal fade" id="myModal<?php echo $j ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">
                                                Confirmação (ID: <?php echo $resposta->id ?>)
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <h3>Deseja mesmo deletar esta resposta?</h3>
                                            <h5>Ao deletar, o anexo também será excluído!</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <input type="hidden" value="<?php echo $resposta->id ?>" name="id">
                                            <input type="hidden" value="<?php echo $topico->id ?>" name="topico_id">
                                            <input type='hidden' value='<?php echo $resposta->anexo ?>' name='resposta_anexo'>
                                            <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::DELETAR_RESPOSTA?>">
                                            <button type="submit" class="btn btn-danger">
                                                <span class="glyphicon glyphicon-remove"></span>
                                                Deletar resposta
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" style="width: 100%;" class="btn btn-danger btn-block" data-toggle="modal" data-target="#myModal<?php echo $j ?>">
                                <span class="glyphicon glyphicon-remove"></span>
                                Deletar Resposta
                            </button>
                        </form>
                    <?php } ?>
                </div>
                <div class="col-md-9">
                    <div id="mensagem">
                        <?php
                        echo $resposta->resposta = str_replace("\n", "<br />", $resposta->resposta) . "<br>";
                        ?>
                    </div>
                    <span style="color: green">Anexo:</span>
                    <?php
                    if (file_exists("arquivos_forum_anexo/$resposta->anexo")) {
                        chmod("arquivos_forum_anexo/$resposta->anexo", 0755);
                        echo "<a target='_blank' href='arquivos_forum_anexo/$resposta->anexo'><span>$resposta->anexo</span></a>";
                    } else {
                        echo "Sem anexo";
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
} else {
    echo "nenhum tópico selecionado";
}
?>
