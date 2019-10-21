<?php
isUserInRole(array("administrador", "orientador", "bolsista"));
;

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
};
?>
<div class="panel-body">
    <?php include 'forum_texto.php'; ?>
    <?php
    if ($info == "area") {
        $area = "";
        if (isset($_GET["area"])) {
            $area = $_GET["area"];
        }
        $sql = "select * from ejbsm_forum_area where id = '$area'";
        $row = mysqli_fetch_object($link->query($sql));
        ?>
        <div class="panel-heading">
            <h3 class="panel-title">Informações da área <?php echo $row->id; ?></h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-info" role="alert">
                Nome: <?php echo $row->nome; ?><br>
                Descrição: <?php echo $row->descricao; ?>
            </div>
        </div>
    <?php
    } elseif ($info == "subarea") {
        $subarea = "";
        if (isset($_GET["subarea"])) {
            $subarea = $_GET["subarea"];
        }
        $sql = "select * from ejbsm_forum_subarea where id = '$subarea'";
        $row = mysqli_fetch_object($link->query($sql));
        ?>
        <h3>Informações da subárea <?php echo $subarea; ?></h3>
        <div class="alert alert-info" role="alert">
            Nome: <?php echo $row->nome; ?><br>
            Descrição: <?php echo $row->descricao; ?>
        </div>
    <?php
    } elseif ($info == "login") {
        $login = $_GET["login"];
        $sql = "select * from ejbsm_usuario where login = '$login'";
        $row = mysqli_fetch_object($link->query($sql));
        ?>
        <h3>Informações do usuário <?php echo $login; ?></h3>

        <div class="alert <?php if ($row->status == 1) {
        } else {
            echo "alert-danger";
        } ?>" role="alert">
            <table>
                <tr>
                    <td rowspan="7" style="width: 210px">
                        <?imagem($row->login, 100)?>
                    </td>
                    <td>
                        Nome: <?php echo $row->nome; ?><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Permissões: <?php echo $row->permissao; ?><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        E-mail: <?php echo $row->email; ?><br>
                    </td>
                </tr>
                <?php if ($user_permissao != "usuario") { ?>
                <tr>
                    <td>
                        Telefone: <?php echo $row->fixo; ?><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Celular: <?php echo $row->celular; ?><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Status: <?php echo $row->status; ?>
                    </td>
                </tr>
                <?php }?>
            </table>
            <?php if ($user_permissao == "administrador") { ?>
                <form action="controller/SystemController.php" method="post">
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
                                    <?php if ($row->status == 1) { ?>
                                        <h3>Deseja mesmo desativar este usuário?</h3>
                                        <h5>Ao desativar este usuário, ele não será excluído, más será impedido de logar
                                            novamente no sistema.</h5>
                                    <?php } else { ?>
                                        <h3>Deseja mesmo reativar este usuário?</h3>
                                        <h5>Ao reativar este usuário, ele terá novamente permissão de logar no
                                            sistema.</h5>
                                    <?php } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Cancelar
                                    </button>
                                    <input type="hidden" value="<?php echo $row->login ?>" name="login">
                                    <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::ATIVAR_DESATIVAR?>">
                                    <?php if ($row->status == 1) { ?>
                                        <button type="submit" class="btn btn-danger" name="op"
                                                value="0">
                                            <span class="glyphicon glyphicon-remove"></span>
                                            Desativar usuário
                                        </button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-warning" name="op"
                                                value="1">
                                            <span class="glyphicon glyphicon-repeat"></span>
                                            Reativar usuário
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Button trigger modal -->
                <button type="button" style="width: 20%;" class="btn btn-warning"
                        data-toggle="modal"
                        data-target="#myModal">
                    <?php if ($row->status == 1) { ?>
                        <span class="glyphicon glyphicon-remove-sign"></span>
                        Desativar usuário
                    <?php } else { ?>
                        <span class="glyphicon glyphicon-repeat"></span>
                        Reativar usuário
                    <?php } ?>
                </button>
            <?php } ?>
        </div>
    <?php } ?>
</div>
