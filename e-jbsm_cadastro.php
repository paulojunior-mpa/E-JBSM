<?
include 'Service/Conexao.php';
include 'e-jbsm_cabecalho.php';
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Cadastro de ?????</h3>

        <?
        if (isset($_GET["info"])) {
            $info = $_GET["info"];
            if ($info == "cadastrado") {
                ?>
                <div class="alert alert-success">
                    Cadastrado.
                </div>
            <?
            }
        }
        ?>

        <form action="Servlet/Cadastro_controller.php" method="post">
            <div class="row">
                <div class="col-md-6">
                    Nome
                    <input class="form-control" required="" type="text" placeholder="" name="nome">
                    Cidade
                    <input class="form-control" required="" type="text" placeholder="" name="cidade">
                    E-mail
                    <input class="form-control" required="" type="email" placeholder="" name="email">
                    Fone
                    <input class="form-control" required="" type="number" placeholder="" name="fone">
                </div>
                <div class="col-md-6">
                    Curso
                    <input class="form-control" required="" type="text" placeholder="" name="curso">
                    Data
                    <input class="form-control" required="" type="date" placeholder="" name="data">
                    Hora
                    <input class="form-control" required="" type="time" placeholder="" name="hora">
                    Anexo
                    <textarea class="form-control" required="" placeholder="" name="anexo"></textarea>
                </div>
                <div class="col-md-6">
                    <br>
                    <button class="btn btn-success" name="opcao" value="cadastrar">
                        <span class="glyphicon glyphicon-save"></span> Cadastrar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>