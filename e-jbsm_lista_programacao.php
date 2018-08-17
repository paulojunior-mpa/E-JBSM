<?
$permissao = array("bolsista", "orientador", "administrador");
include 'helpers/permitir.php';
?>
<ul class="nav nav-tabs" role="tablist" id="cadastro_programacao" xmlns="http://www.w3.org/1999/html">
    <li role="presentation">
        <?
        if ($user_permissao == "bolsista") {
            echo '<a href="e-jbsm_cadastro_programacao.php">';
        } else {
            echo '<a>';
        } ?>
        Cadastro de programação
        </a>
    </li>
    <li role="presentation" class="active"><a href="">Lista de programações</a></li>
</ul>
<?
if (isset($_GET["info"]) and $_GET["info"] == "excluida") {
    echo '<div class="alert alert-danger" role="alert">Programação excluída!</div>';
}elseif (isset($_GET["info"]) and $_GET["info"] == "editada") {
    echo '<div class="alert alert-warning" role="alert">Programação editada!</div>';
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de programações</h3>
        <?
        if ($user_permissao == "bolsista") {
            $condicao = " where login = '$user_login'";
        } else {
            $condicao = "";
        }
        $inicio_consulta = "";
        if (isset($_GET["inicio_consulta"])) {
            $inicio_consulta = $_GET["inicio_consulta"];
        }
        if ($inicio_consulta != "" and $inicio_consulta > 0)
            $sql = "select * from ejbsm_programacao $condicao order by id desc limit 10 offset $inicio_consulta;";

        else
            $sql = "select * from ejbsm_programacao $condicao order by id desc limit 10;";

        $qr = $link->query($sql);
        $j = 0;
        while ($r = mysqli_fetch_object($qr)) {
            $j++;
            ?>
            <div id='cssmenu'>
                <ul>
                    <li class='active has-sub'>
                        <a>
                        <span>
                            <div style="color: green"><b>Login: </b></div><? echo "{$r->login}"; ?>
                            <div style="color: green"><b>Data: </b></div><? echo "{$r->data}"; ?>
                            <div style="color: green"><b>Código: </b></div><? echo "{$r->id}"; ?>
                        </span>
                        </a>
                        <ul>
                            <li class='has-sub'>
                                <a>
                                    <table class="table table-hover">
                                        <tr>
                                            <td>
                                                <div style="color: green"><b>Motivação:</div>
                                            </td>
                                            <td>
                                                <? echo "{$r->emocional}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green">
                                                    <b>Fato significativo:</b>
                                                </div>
                                            </td>
                                            <td>
                                                <? echo "{$r->fato_significativo}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green">
                                                    <b>
                                                        Pontos produtivos:
                                                    </b>
                                                </div>
                                            </td>
                                            <td>
                                                <? echo "{$r->produtivos}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green">
                                                    <b>
                                                        Pontos improdutivos:
                                                    </b>
                                                </div>
                                            </td>
                                            <td>
                                                <? echo "{$r->improdutivos}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green">
                                                    <b>
                                                        Material necessário:
                                                    </b>
                                                </div>
                                            </td>
                                            <td>
                                                <? echo "{$r->material_necessario}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green"><b>Sugestão:</b></div>
                                            </td>
                                            <td>
                                                <? echo "{$r->sugestao}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green">
                                                    <b>
                                                        Atividades prioritárias para a próxima semana:
                                                    </b>
                                                </div>
                                            </td>
                                            <td>
                                                <? echo "{$r->prioridades}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green"><b>Segunda: </b></div>
                                            </td>
                                            <td>
                                                <? echo "{$r->segunda}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green"><b>Terça: </b></div>
                                            </td>
                                            <td>
                                                <? echo "{$r->terca}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green"><b>Quarta: </b></div>
                                            </td>
                                            <td>
                                                <? echo "{$r->quarta}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green"><b>Quinta: </b></div>
                                            </td>
                                            <td>
                                                <? echo "{$r->quinta}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="color: green"><b>Sexta: </b></div>
                                            </td>
                                            <td>
                                                <? echo "{$r->sexta}"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <form action="e-jbsm_editar_programacao.php" method="post">
                                                    <input type="hidden" value="<?= $r->id ?>" name="id">
                                                    <button class="btn btn-warning" value="Editar" name="opcao">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                        Editar
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="controller/Controller.php" method="post">
                                                    <button type="button" class="btn btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#myModal<?= $j ?>">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                        Deletar programação
                                                    </button>
                                                    <input type="hidden" value="<?= $r->id ?>"
                                                           name="id">
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal<?= $j ?>" tabindex="-1"
                                                         role="dialog" aria-labelledby="myModalLabel"
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
                                                                    <h3>Deseja mesmo excluir esta programação?
                                                                        (ID: <?= $r->id ?>)</h3>
                                                                    <h5></h5>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar
                                                                    </button>
                                                                    <input type="hidden" name="opcao" id="opcao" value="<?=Constantes::DELETAR_PROGRAMACAO?>">
                                                                    <button type="submit"  class="btn btn-danger">
                                                                        <span class="glyphicon glyphicon-remove"></span>
                                                                        Deletar programação
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <hr>
        <? } ?>
        <nav>
            <ul class="pagination">
                <?
                if ($inicio_consulta != "" and $inicio_consulta != 0) {
                    ?>
                    <li>
                        <a href="e-jbsm_lista_programacao.php?inicio_consulta=<?= $inicio_consulta - 10 ?>">&laquo;</a>
                    </li>
                <?php } ?>
                <li>
                    <a href="e-jbsm_lista_programacao.php?inicio_consulta=<?= 0 ?>#primeira_programacao">1</a>
                </li>
                <li>
                    <a href="e-jbsm_lista_programacao.php?inicio_consulta=<?= 10 ?>#primeira_programacao">2</a>
                </li>
                <li>
                    <a href="e-jbsm_lista_programacao.php?inicio_consulta=<?= 20 ?>#primeira_programacao">3</a>
                </li>
                <li>
                    <a href="e-jbsm_lista_programacao.php?inicio_consulta=<?= 30 ?>#primeira_programacao">4</a>
                </li>
                <li>
                    <a href="e-jbsm_lista_programacao.php?inicio_consulta=<?= 40 ?>#primeira_programacao">5</a>
                </li>
                <li>
                    <a href="e-jbsm_lista_programacao.php?inicio_consulta=<?= $inicio_consulta + 10 ?>">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
