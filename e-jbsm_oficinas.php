<?php
isUserInRole(array("usuario", "administrador", "orientador", "bolsista"));
;
$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
if ($info == "editada") {
    echo '<div class="alert alert-warning" role="alert">
        Oficina alterada!
    </div>';

} elseif ($info == "cadastrada") {
    echo '<div class="alert alert-success" role="alert">
        Oficina cadastrada!
    </div>';
} elseif ($info == "deletada") {
    echo '<div class="alert alert-danger" role="alert">
        Oficina deletada!
    </div>';
}
if ($user_permissao != "usuario") { ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Cadastro de Oficinas:</h3>
            <form action="controller/SystemController.php" method="post">
                <table class="table">
                    <tr>
                        <td>Nome
                            <input type="text" class="form-control" placeholder="Nome da oficina" name="nome" required>
                        </td>
                        <td>Monitor
                            <select name="nome_monitor" class="form-control" required>
                                <?php
                                $sql = "select * from ejbsm_usuario, ejbsm_integrante WHERE ejbsm_usuario.login = ejbsm_integrante.login and monitor AND status != 0";
                                $result = $link->query($sql);
                                while ($row = mysqli_fetch_object($result)) {
                                    $Pnome = explode(" ", $row->nome);
                                    ?>
                                    <option value="<?php echo $row->nome ?>"><?php echo "$row->login / ";
                                        echo "$Pnome[0]"; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td colspan="2">Orientador
                            <select name="orientador" class="form-control" required>
                                <?php
                                $sql = "select * from ejbsm_usuario where permissao = 'orientador' or permissao = 'administrador' and status != 0;";
                                $result = $link->query($sql);
                                while ($row = mysqli_fetch_object($result)) {
                                    $Pnome = explode(" ", $row->nome);
                                    ?>
                                    <option value="<?php echo $row->nome ?>"><?php echo "$row->login / ";
                                        echo "$Pnome[0]"; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Descrição
                            <textarea class="form-control" cols="80" rows="3" placeholder="Descrição" name="descricao"
                                      required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Material utilizado
                            <textarea class="form-control" cols="80" rows="3" placeholder="Material" name="material"
                                      required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Link para mais informações
                            <textarea class="form-control" cols="80" rows="3" placeholder="Link" name="link"
                                      required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::CADASTRAR_OFICINA?>">
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
        <?php
        $sql = "select * from ejbsm_oficina order by id desc;";
        $result = $link->query($sql);
        $numero = mysqli_num_rows($result);
        echo "<h3>Lista de Oficinas($numero)</h3>";
        while ($row = mysqli_fetch_object($result)) {
            ?>
            <div id='cssmenu'>
                <ul>
                    <li class='active has-sub'>
                        <a>
                        <span>
                            <table>
                                <tr>
                                    <td><b>ID: </b><?php echo $row->id ?> </td>
                                    <td><b>Nome: </b><?php echo $row->nome ?></td>
                                    <td><b>Monitor: </b><?php echo $row->monitor ?></td>
                                    <td><b>Orientador: </b><?php echo $row->orientador ?></td>
                                </tr>
                            </table>
                        </span>
                        </a>
                        <ul>
                            <li class='has-sub'>
                                <table class="table">
                                    <tr>
                                        <td colspan="2">
                                            <b>Nome: </b><?php echo $row->nome ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <b>Monitor: </b><?php echo $row->monitor ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <b>Descrição da oficina: </b><?php echo $row->descricao ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <b>Orientador: </b><?php echo $row->orientador ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <b>Material utilizado: </b><?php echo $row->material ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <b>Link para informações ou referências: </b><?php echo $row->anexo ?>
                                        </td>
                                    </tr>
                                    <?php if ($user_permissao != "usuario") { ?>
                                        <tr>
                                            <td>
                                                <form action="e-jbsm_editar_oficina.php" method="post">
                                                    <input class="form-control" type="hidden" name="id"
                                                           value="<?php echo $row->id ?>">
                                                    <button class="btn btn-warning" type="submit" name="opcao"
                                                            value="Editar">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                        Editar
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="controller/SystemController.php" method="post">
                                                    <input class="form-control" type="hidden" name="id"
                                                           value="<?php echo $row->id ?>">
                                                    <!-- Modal -->
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#myModal">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                        Excluir oficina
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
                                                                    <h3>Deseja mesmo excluir esta oficina?
                                                                        (ID: <?php echo $row->id ?>)</h3>
                                                                    <h5></h5>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Cancelar
                                                                    </button>
                                                                    <input type="hidden" value="<?php echo $row->id ?>" name="codigo">
                                                                    <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::DELETAR_OFICINA?>">
                                                                    <button type="submit" value="Deletar oficina" class="btn btn-danger">
                                                                        <span class="glyphicon glyphicon-remove"></span>
                                                                        Excluir oficina
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