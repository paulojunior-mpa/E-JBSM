<?
$permissao = array("administrador", "orientador", "bolsista");
include 'Func/permitir_app.php';

$inicio_consulta = "";
$info = "";
if (isset($_GET["inicio_consulta"])) {
    $inicio_consulta = $_GET["inicio_consulta"];
}
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Cadastro de trilhas</h3>

        <div class="row">
            <div class="col-md-3">
                <? include "app_menu.php"; ?>
            </div>
            <div class="col-md-9">
                <?
                if($info=="deletada"){
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-remove-circle"></span>
                        Trilha deletada.
                    </div>
                <?
                }
                ?>

                <h4>Cadastro de trilha</h4>

                <form action="Servlet/app_controll.php" method="post">
                    Nome da trilha
                    <input class="form-control" type="text" name="nome" placeholder="nome" required="">
                    Descrição da trilha
                    <input class="form-control" type="text" name="descricao" placeholder="descricao" required="">
                    <br>
                    <button class="btn btn-success" name="opcao" value="Cadastrar trilha">
                        <span class="glyphicon glyphicon-save"></span>
                        Cadastrar
                    </button>
                </form>
            </div>
            <div class="col-md-9">
                <h4>Trilhas cadastradas. Slecione para editar</h4>
                <?
                $sql = "select * from ejbsm_trilha";
                $result = $link->query($sql) or die(mysqli_error($link));
                while ($trilha = mysqli_fetch_object($result)) {
                    echo "<a href='app_editar_trilha.php?trilha_id=$trilha->id' class='list-group-item'><span>Nome:</span> $trilha->nome</a>";
                }
                ?>
            </div>
        </div>
    </div>
</div>