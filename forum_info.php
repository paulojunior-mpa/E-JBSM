<?
$permissao = array("administrador", "orientador", "bolsista");
include 'helpers/permitir.php';

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
};
?>
<div class="panel-body">
    <? include 'forum_texto.php'; ?>
    <?
    if ($info == "area") {
        $area = "";
        if (isset($_GET["area"])) {
            $area = $_GET["area"];
        }
        $sql = "select * from ejbsm_forum_area where id = '$area'";
        $row = mysqli_fetch_object($link->query($sql));
        ?>
        <div class="panel-heading">
            <h3 class="panel-title">Informações da área <? echo $row->id; ?></h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-info" role="alert">
                Nome: <? echo $row->nome; ?><br>
                Descrição: <? echo $row->descricao; ?>
            </div>
        </div>
    <?
    } elseif ($info == "subarea") {
        $subarea = "";
        if (isset($_GET["subarea"])) {
            $subarea = $_GET["subarea"];
        }
        $sql = "select * from ejbsm_forum_subarea where id = '$subarea'";
        $row = mysqli_fetch_object($link->query($sql));
        ?>
        <h3>Informações da subárea <? echo $subarea; ?></h3>
        <div class="alert alert-info" role="alert">
            Nome: <? echo $row->nome; ?><br>
            Descrição: <? echo $row->descricao; ?>
        </div>
    <?
    } elseif ($info == "login") {
        $login = $_GET["login"];
        $sql = "select * from ejbsm_usuario where login = '$login'";
        $row = mysqli_fetch_object($link->query($sql));
        ?>
        <h3>Informações do usuário <? echo $login; ?></h3>

        <div class="alert <? if ($row->status == "Ativo") {
        } else {
            echo "alert-danger";
        } ?>" role="alert">
            <table>
                <tr>
                    <td rowspan="7" style="width: 210px">
                        <?Imagem($row->login, 100)?>
                    </td>
                    <td>
                        Nome: <? echo $row->nome; ?><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Permissões: <? echo $row->permissao; ?><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        E-mail: <? echo $row->email; ?><br>
                    </td>
                </tr>
                <? if ($user_permissao != "usuario") { ?>
                <tr>
                    <td>
                        Telefone: <? echo $row->fixo; ?><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Celular: <? echo $row->celular; ?><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Status: <? echo $row->status; ?>
                    </td>
                </tr>
                <?}?>
            </table>
            <? if ($user_permissao == "administrador") { ?>
                <form action="controller/Controller.php" method="post">
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Comfirmação</h4>
                                </div>
                                <div class="modal-body">
                                    <? if ($row->status == "Ativo") { ?>
                                        <h3>Deseja mesmo desativar este usuário?</h3>
                                        <h5>Ao desativar este usuário, ele não será excluído, más será impedido de logar
                                            novamente no sistema.</h5>
                                    <? } else { ?>
                                        <h3>Deseja mesmo reativar este usuário?</h3>
                                        <h5>Ao reativar este usuário, ele terá novamente permissão de logar no
                                            sistema.</h5>
                                    <? } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Cancelar
                                    </button>
                                    <input type="hidden" value="<?= $row->login ?>" name="login">
                                    <input type="hidden" name="opcao" id="opcao" value="<?=Constantes::ATIVAR_DESATIVAR?>">
                                    <? if ($row->status == "Ativo") { ?>
                                        <button type="submit" class="btn btn-danger" name="op"
                                                value="Inativo">
                                            <span class="glyphicon glyphicon-remove"></span>
                                            Desativar usuário
                                        </button>
                                    <? } else { ?>
                                        <button type="submit" class="btn btn-warning" name="op"
                                                value="Ativo">
                                            <span class="glyphicon glyphicon-repeat"></span>
                                            Reativar usuário
                                        </button>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Button trigger modal -->
                <button type="button" style="width: 20%;" class="btn btn-warning"
                        data-toggle="modal"
                        data-target="#myModal">
                    <? if ($row->status == "Ativo") { ?>
                        <span class="glyphicon glyphicon-remove-sign"></span>
                        Desativar usuário
                    <? } else { ?>
                        <span class="glyphicon glyphicon-repeat"></span>
                        Reativar usuário
                    <? } ?>
                </button>
            <? } ?>
        </div>
    <? } ?>
</div>
