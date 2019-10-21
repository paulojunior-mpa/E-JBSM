<?
isUserInRole(array("administrador", "orientador", "bolsista"));
;

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel-body">
    <?php include 'forum_texto.php'; ?>
    <h3>Lista de subáreas</h3>
    <?php if ($info == "alterada") { ?>
        <div class="alert alert-success" role="alert">Subárea alterada!<br>Tópicos desta subárea foram atualizados.
        </div>
    <?php }
    if ($info == "subarea_deletada") { ?>
        <div class="alert alert-success" role="alert">
            Subárea deletada com sucesso!<br>Tópicos desta área foram movidos.
        </div>
    <?php
    }
    $sql = "select * from ejbsm_forum_subarea where status = 'ativa';";
    $qr = $link->query($sql) or die(mysql_error());
    $j=1;
    while ($subarea = mysqli_fetch_object($qr)) {
        ?>
        <hr>
        <div id='cssmenu'>
            <ul>
                <li class='active has-sub'>
                    <a>
                        <span>
                            <span style="color: green"><b>Nome: </b></span> <?php echo $subarea->nome ?><br><br>
                            <span style="color: green"><b>Descrição: </b></span> <?php echo $subarea->descricao ?><br><br>
                            <?
                            $sql = "select nome from ejbsm_forum_area where id = $subarea->id_area";
                            $pega_nome = mysqli_fetch_object($link->query($sql));
                            $nome_area = $pega_nome->nome;
                            ?>
                            <span style="color: green"><b>Área: </b></span> <?php echo $nome_area ?>
                        </span>
                    </a>
                    <?php if ($user_permissao != "usuario") { ?>
                        <ul>
                            <li class='has-sub'>
                                <a>
                                    <form action="controller/ForumController.php" method="post">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="subarea_nome"
                                                           value="<?php echo $subarea->nome ?>" required="">
                                                </td>
                                                <td>
                                                    <select name="subarea_area" class="form-control">
                                                        <?php
                                                        $sql2 = "select * from ejbsm_forum_area;";
                                                        $qr2 = $link->query($sql2) or die(mysqli_error($link));
                                                        while ($area = mysqli_fetch_object($qr2)) {
                                                            ?>
                                                            <option
                                                                value="<?php echo $area->id ?>"><?php echo $area->nome ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="subarea_descricao" class="form-control"
                                                              placeholder="<?php echo $subarea->descricao ?>"
                                                              required=""><?php echo $subarea->descricao ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="hidden" value="<?php echo $subarea->id ?>" name="id">
                                                    <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::EDITAR_SUBAREA?>">
                                                    <button type="submit" class="btn btn-warning">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                        Salvar edição
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <?php if ($user_permissao == "administrador" or $user_permissao == "orientador") { ?>
                                        <form action="controller/ForumController.php" method="post">
                                            <div class="modal fade" id="myModal<?php echo $j?>" tabindex="-1" role="dialog"
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
                                                            <h3>Deseja mesmo deletar a subárea <?php echo $subarea->nome?></h3>
                                                            <?if($subarea->id!=1){?>
                                                            <h5>Ao deletar, todos os topicos relacionados serão movidos para a subárea padrão 'Outros'.</h5>
                                                            <?}else{?>
                                                                <h5>Esta subárea não pode ser excluída.</h5>
                                                            <?}?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">
                                                                Cancelar
                                                            </button>
                                                            <?if($subarea->id!=1){?>
                                                                <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::DELETAR_SUBAREA?>">
                                                                <button type="submit" class="btn btn-danger">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                    Deletar subárea
                                                                </button>
                                                            <?}?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $j?>">
                                                <span class="glyphicon glyphicon-remove"></span>
                                                Deletar Subárea
                                            </button>
                                            <div class="input-group">
                                                <input type="hidden" value="<?php echo $subarea->id ?>" name="id">
                                            </div>
                                        </form>
                                    <?php } ?>
                                </a>
                            </li>
                        </ul>
                    <?php } ?>
                </li>
            </ul>
        </div>
        <?php
        $j++;
    }
    ?>
</div>