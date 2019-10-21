<?
isUserInRole(array("administrador", "orientador", "bolsista"));
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Lista de cadastros</h3>

        <?
        if (isset($_GET["info"])) {
            $info = $_GET["info"];
            if ($info == "deletado") {
                ?>
                <div class="alert alert-warning">
                    Deletado.
                </div>
                <?
            }
        }
        ?>

        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Fone</th>
                    <th>Curso</th>
                    <th>Cidade</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Anexo</th>
                    <th>Cadastro em</th>
                    <th>ID</th>
                    <th></th>
                </tr>
                <?
                $sql = "select * from ejbsm_cadastro";
                if($result = $link->query($sql)) {
                    while ($row = mysqli_fetch_object($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row->nome ?></td>
                            <td><?php echo $row->email ?></td>
                            <td><?php echo $row->fone ?></td>
                            <td><?php echo $row->curso ?></td>
                            <td><?php echo $row->cidade ?></td>
                            <td><?php echo $row->data ?></td>
                            <td><?php echo $row->hora ?></td>
                            <td><?php echo $row->anexo ?></td>
                            <td><?php echo $row->now_date_time ?></td>
                            <td><?php echo $row->id ?></td>
                            <td>
                                <form action="controller/Cadastro_controller.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $row->id ?>">
                                    <button class="btn btn-danger" name="opcao" value="deletar">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>