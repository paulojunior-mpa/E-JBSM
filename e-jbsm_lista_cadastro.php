<?
$permissao = array("administrador", "orientador", "bolsista");
include 'functions/permitir.php';
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
                    <th>Ação</th>
                </tr>
                <?
                $sql = "select * from ejbsm_cadastro";
                $result = $link->query($sql);
                while ($row = mysqli_fetch_object($result)) {
                    ?>
                    <tr>
                        <td><?=$row->nome?></td>
                        <td><?=$row->email?></td>
                        <td><?=$row->fone?></td>
                        <td><?=$row->curso?></td>
                        <td><?=$row->cidade?></td>
                        <td><?=$row->data?></td>
                        <td><?=$row->hora?></td>
                        <td><?=$row->anexo?></td>
                        <td><?=$row->now_date_time?></td>
                        <td><?=$row->id?></td>
                        <td>
                            <form action="controller/Cadastro_controller.php" method="post">
                                <input type="hidden" name="id" value="<?=$row->id?>">
                                <button class="btn btn-danger" name="opcao" value="deletar">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?
                }
                ?>
            </table>
        </div>
    </div>
</div>