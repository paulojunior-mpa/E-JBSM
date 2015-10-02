<?
$permissao = array("administrador", "orientador", "bolsista");
include 'Func/permitir.php';

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel-body">
    <? include 'forum_texto.php'; ?>
    <h3>Lista de áreas</h3>
    <? if ($info == "alterada") { ?>
        <div class="alert alert-success" role="alert">
            Área alterada!<br>Subáreas desta área foram atualizadas.<br>Tópicos desta área foram atualizados.
        </div>
    <?php }
    if ($info == "area_deletada") { ?>
        <div class="alert alert-success" role="alert">
            Área deletada com sucesso!<br>Subáreas desta área foram movidas.<br>
            Tópicos desta área foram movidos.
        </div>
    <?php
    }
    $sql = "select * from ejbsm_forum_area where status = 'ativa';";
    $qr = $link->query($sql) or die(mysql_error());
    $j=1;
    while ($area = mysqli_fetch_object($qr)) {
        ?>
        <hr>
        <div id='cssmenu'>
            <ul>
                <li class='active has-sub'>
                    <a>
                        <span>
                            <font color="green"><b>Nome: </b></font> <? echo $area->nome ?><br><br>
                            <font color="green"><b>Descrição: </b></font> <? echo $area->descricao ?>
                        </span>
                    </a>
                    <? if ($user_permissao != "usuario") { ?>
                        <ul>
                            <li class='has-sub'>
                                <a>
                                    <form action="Servlet/Forum_Controller.php" method="post">
                                        <table class="table">
                                            <tr>
                                                <td>Nome da área
                                                    <input type="text" class="form-control" name="area_nome"
                                                           value="<?= $area->nome ?>" required="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Descrição da área
                                                    <textarea name="area_descricao" class="form-control"
                                                              placeholder="<?= $area->descricao ?>"
                                                              required=""><?= $area->descricao ?>
                                                </textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="hidden" value="<?= $area->id ?>" name="id">
                                                    <button type="submit" class="btn btn-warning" value="Editar área"
                                                            name="opcao">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                        Salvar edição
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <? if ($user_permissao == "administrador" or $user_permissao == "orientador") { ?>
                                        <form action="Servlet/Forum_Controller.php" method="post">
                                            <div class="modal fade" id="myModal<?=$j?>" tabindex="-1" role="dialog"
                                                 aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span>
                                                            </button>
                                                            <h4 class="modal-title" id="myModalLabel">Confirmação</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3>Deseja mesmo deletar a área <?=$area->nome?></h3>
                                                            <?if($area->id!=1){?>
                                                            <h5>Ao deletar, todas as subáreas e topicos relacionados serão movidos para a área padrão 'Outros'.</h5>
                                                            <?}else{?>
                                                                <h5>Esta área não pode ser exlcuída.</h5>
                                                            <?}?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">
                                                                Cancelar
                                                            </button>
                                                            <?if($area->id!=1){?>
                                                            <button type="submit" class="btn btn-danger" name="opcao"
                                                                    value="Deletar área">
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                                Deletar área
                                                            </button>
                                                            <?}?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger"
                                                    data-toggle="modal"
                                                    data-target="#myModal<?=$j?>">
                                                <span class="glyphicon glyphicon-remove"></span>
                                                Deletar Área
                                            </button>
                                            <input type="hidden" value="<?= $area->id ?>" name="id">
                                        </form>
                                    <? } ?>
                                </a>
                            </li>
                        </ul>
                    <? } ?>
                </li>
            </ul>
        </div>
        <?php
        $j++;
    }
    ?>
</div>