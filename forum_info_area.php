<?php
isUserInRole(array("administrador", "orientador", "bolsista"));

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel-body">
    <?php include 'forum_texto.php'; ?>
    <h3>Lista de áreas</h3>
    <?php if ($info == "alterada") { ?>
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
                            <span="color: green"><b>Nome: </b></span> <?php echo $area->nome ?><br><br>
                            <span style="color: green"><b>Descrição: </b></span> <?php echo $area->descricao ?>
                        </span>
                    </a>
                    <?php if ($user_permissao != "usuario") { ?>
                        <ul>
                            <li class='has-sub'>
                                <a>
                                    <form action="controller/ForumController.php" method="post">
                                        <table class="table">
                                            <tr>
                                                <td>Nome da área
                                                    <input type="text" class="form-control" name="area_nome"
                                                           value="<?php echo $area->nome ?>" required="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Descrição da área
                                                    <textarea name="area_descricao" class="form-control"
                                                              placeholder="<?php echo $area->descricao ?>"
                                                              required=""><?php echo $area->descricao ?>
                                                </textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="hidden" value="<?php echo $area->id ?>" name="id">
                                                    <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::EDITAR_AREA?>">
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
                                                            <h3>Deseja mesmo deletar a área <?php echo $area->nome?></h3>
                                                            <?php if($area->id!=1){?>
                                                            <h5>Ao deletar, todas as subáreas e topicos relacionados serão movidos para a área padrão 'Outros'.</h5>
                                                            <?php }else{?>
                                                                <h5>Esta área não pode ser exlcuída.</h5>
                                                            <?php }?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">
                                                                Cancelar
                                                            </button>
                                                            <?php if($area->id!=1){?>
                                                                <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::DELETAR_AREA?>">
                                                                <button type="submit" class="btn btn-danger">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                    Deletar área
                                                                </button>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $j?>">
                                                <span class="glyphicon glyphicon-remove"></span>
                                                Deletar Área
                                            </button>
                                            <input type="hidden" value="<?php echo $area->id ?>" name="id">
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