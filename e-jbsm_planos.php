<?
isUserInRole(array("usuario", "administrador", "orientador", "bolsista"));
;
$info = "";
if(isset($_GET["info"])){
    $info = $_GET["info"];
}
if ($info == "editado") {
    echo '<div class="alert alert-warning" role="alert">
        Plano editado!
    </div>';
}elseif ($info == "cadastrado") {
    echo '<div class="alert alert-success" role="alert">
        Plano cadastrada!
    </div>';
} elseif ($info == "excluido") {
    echo '<div class="alert alert-danger" role="alert">
        Plano deletado!
    </div>';
}
if ($user_permissao != "usuario") { ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Cadastro de Plano de Visitas.</h3>
            <form action="controller/SystemController.php" method="post">
                <table class="table">
                    <tr>
                        <td>Nome
                            <input type="text" class="form-control" placeholder="Nome do Plano" name="nome" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Público alvo
                            <input type="text" class="form-control" placeholder="Público alvo" name="publicoAlvo"
                                   required>
                        </td>
                    </tr>
                    <tr>
                        <td>Guia
                            <select name="nomeGuia" class="form-control" required>
                                <?
                                $sql = "select * from ejbsm_usuario, ejbsm_integrante WHERE ejbsm_usuario.login = ejbsm_integrante.login and monitor AND status != 0";
                                $result = $link->query($sql);
                                while ($r = mysqli_fetch_object($result)) {
                                    $Pnome = explode(" ", $r->nome);
                                    ?>
                                    <option value="<?php echo $Pnome[0] ?>"><?php echo "$r->login / ";
                                        echo "$Pnome[0]"; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Objetivo
                            <textarea class="form-control" cols="80" rows="3" placeholder="Objetivo" name="objetivo"
                                      required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Assuntos
                             <textarea class="form-control" cols="80" rows="3" placeholder="Assuntos para abordar"
                                       name="assunto"
                                       required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Estratégias cognitivas
                            <textarea class="form-control" cols="80" rows="3" placeholder="Estratégias cognitivas"
                                      name="estrategia"
                                      required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Recursos
                            <textarea class="form-control" cols="80" rows="3" placeholder="Recursos extras"
                                      name="recursos"
                                      required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Locais para visitar
                            <textarea class="form-control" cols="80" rows="3" placeholder="Locais a serem visitados"
                                      name="locais"
                                      required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Relevancia de locais
                            <textarea class="form-control" cols="80" rows="3" placeholder="Relevância de cada local"
                                      name="relevancia"
                                      required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Instrumentos de coleta de dados
                            <textarea class="form-control" cols="80" rows="3"
                                      placeholder="Instrumento de coleta de dados"
                                      name="instrumento" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::CADASTRAR_PLANO?>">
                            <button class="btn btn-success" type="submit">
                                <span class="glyphicon glyphicon-save"></span>
                                Cadastrar
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php } ?>
<div class="panel panel-default">
    <div class="panel-body">
        <?
        $sql = "select * from ejbsm_plano order by id desc;";
        $result = $link->query($sql);
        $numero = mysqli_num_rows($result);
        echo "<h3>Lista de Planos de Visitas($numero)</h3>";
        $j=0;
        while ($r = mysqli_fetch_object($result)) {
            $j++;
            ?>
            <div id='cssmenu'>
                <ul>
                    <li class='active has-sub'>
                        <a>
                        <span>
                            <b>ID: </b><?php echo "{$r->id}"; ?>
                            <b>Nome: </b><?php echo "{$r->nome}"; ?>
                            <b>Publico alvo: </b><?php echo "{$r->publico_alvo}"; ?>
                            <b>Nome do guia: </b><?php echo "{$r->monitor}"; ?>
                            <b>Por: </b><?php echo "{$r->login}"; ?>
                        </span>
                        </a>
                        <ul>
                            <li class='has-sub'>
                                <table class="table">
                                    <tr>
                                        <td colspan="2"><b>Nome: </b><?php echo $r->nome ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Público alvo: </b><?php echo $r->publico_alvo ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Guia: </b><?php echo $r->monitor ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Objetivo: </b><?php echo $r->objetivo ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Assuntos para aobrdar: </b><?php echo $r->assunto ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Recursos extras: </b><?php echo $r->recursos ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Locais a serem visitados: </b><?php echo $r->locais ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Relevância de cada local: </b><?php echo $r->relevancia ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Instrumento de coleta de dados: </b> <?php echo $r->instrumento ?></td>
                                    </tr>
                                    <?php if ($user_permissao != "usuario") { ?>
                                        <tr>
                                            <td>
                                                <form action="e-jbsm_editar_plano.php" method="post">
                                                    <input type="hidden" name="id" value="<?php echo $r->id ?>">
                                                    <button type="submit" class="btn btn-warning" value="Editar">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                        Editar
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="controller/SystemController.php" method="post">
                                                    <input class="form-control" type="hidden" name="id"
                                                           value="<?php echo $r->id ?>">
                                                    <!-- Modal -->
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#myModal">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                        Excluir plano
                                                    </button>
                                                    <div class="modal fade" id="myModal" tabindex="-1"
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
                                                                    <h3>Deseja mesmo excluir este plano?
                                                                        (ID: <?php echo $r->id ?>)</h3>
                                                                    <h5></h5>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Cancelar
                                                                    </button>
                                                                    <input type="hidden" value="<?php echo $r->id ?>" name="codigo">
                                                                    <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::DELETAR_PLANO?>">
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <span class="glyphicon glyphicon-remove"></span>
                                                                        Excluir plano
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <hr>
        <?php } ?>
    </div>
</div>