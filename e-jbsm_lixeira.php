<?
$permissao = array("usuario", "administrador", "orientador", "bolsista");
include 'helpers/permitir.php';
$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}

if ($info == "deletada") {
    echo "<div class='alert alert-danger' role='alert'>Visita deletada!</div>";
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de visitas excluídas</h3>
        <?php
        if ($user_permissao != "usuario") {
            $sql = "select * from ejbsm_visita where excluida != 'nao' order by id desc;";
        } else {
            $sql = "select * from ejbsm_visita where excluida != 'nao' and login = '$user_login';";
        }
        $qr = $link->query($sql);
        $j = 0;
        while ($visita = mysqli_fetch_object($qr)) {
            $j++;
            ?>
            <div id='cssmenu' style="margin-top: 10px;">
                <ul>
                    <li class='active has-sub'>
                        <a>
                        <span>
                            <div class="input-group">
                                <b>ID </b> <div style="color: green"><?php echo $visita->id ?></div>
                                <b> Excluida por:</b><div style="color: green"><?php echo $visita->excluida ?></div>
                                <b> Data: </b><div style="color: green"><?php echo "{$visita->data}"; ?></div>
                                <b> Hora: </b><div style="color: green"><?php echo "{$visita->hora}"; ?></div>
                                <b> Insituicao/Grupo: </b><font
                                    color="green"><?php echo "{$visita->instituicao}"; ?></div>
                            </div>
                        </span>
                        </a>
                        <ul>
                            <li class='has-sub'>
                                <a>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <b>Usuário: </b><?= $visita->login ?><br>
                                                    <b>Data: </b><?= $visita->data ?><br>
                                                    <b>Hora: </b><?= $visita->hora ?><br>
                                                    <b>Oficina:</b><?= $visita->oficina; ?><br>
                                                </div>
                                                <div class="col-md-3">
                                                    <b>Duração de visita:</b><?= $visita->duracao; ?><br>
                                                    <b>Insituicao/Grupo:</b><?= $visita->instituicao; ?><br>
                                                    <b>Tipo de Instituicao:</b><?= $visita->tipo_instituicao; ?><br>
                                                    <b>Monitor:</b><?= $visita->monitor ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <b>Responsável: </b><?= $visita->responsavel; ?><br>
                                                    <b>Cidade: </b><?= $visita->cidade; ?><br>
                                                    <b>Curso / Ano: </b><?= $visita->curso; ?><br>
                                                    <b>Numero de Visitantes: </b><?= $visita->visitantes; ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <b>Telefone: </b><?= $visita->fone; ?><br>
                                                    <b>Conteudo: </b><?= $visita->conteudo; ?><br>
                                                    <b>Auxilio para desenvolver conteudo: </b><?= $visita->auxilio; ?>
                                                    <br>.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <? if ($visita->status != "Confirmada") { ?>
                                                    <div class="col-md-3">
                                                        <form action="controller/Controller.php" method="post">
                                                            <button type="button" class="btn btn-danger"
                                                                    data-toggle="modal"
                                                                    data-target="#myModal<?= $j ?>">
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                                Excluir visita
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="myModal<?= $j ?>" tabindex="-1"
                                                                 role="dialog"
                                                                 aria-labelledby="myModalLabel"
                                                                 aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span>
                                                                            </button>
                                                                            <h4 class="modal-title" id="myModalLabel">
                                                                                Confirmar exclusão.</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <h3>Deseja mesmo excluir esta visita? (ID: <?= $visita->id ?>)</h3>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar
                                                                            </button>
                                                                            <input type="hidden" value="<?= $visita->id ?>" name="id">
                                                                            <input type="hidden" name="opcao" id="opcao" value="<?=Constantes::DELETAR_VISITA?>">
                                                                            <button type="submit" class="btn btn-danger">
                                                                                <span class="glyphicon glyphicon-remove"></span>
                                                                                Deletar visita
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                <? } ?>
                                                <? if ($user_permissao != "usuario") { ?>
                                                    <div class="col-md-3">
                                                        <form action="e-jbsm_editar_visita.php" method="post">
                                                            <div class="input-group">
                                                                <input type="hidden" value="<?= $visita->id ?>" name="id">
                                                                <button type="submit" class="btn btn-warning" value="Editar visita" name="opcao">
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                    Editar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                <? } ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        <? } ?>
    </div>
</div>