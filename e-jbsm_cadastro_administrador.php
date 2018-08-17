<?
$permissao = array("administrador");
include 'helpers/permitir.php';
$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<form action="controller/Controller.php" method="post">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Cadastro de administrador</h3>
            <? if ($info == "cadastrado") { ?>
                <div class="alert alert-success" role="alert">Administrador cadastrado!</div>
            <? } elseif ($info == "login") { ?>
                <div class="alert alert-danger" role="alert">Este login já está cadastrado!</div>
            <? } ?>
            <table class="table">
                <tr>
                    <td><h4>Dados pessoais</h4></td>
                </tr>
                <tr>
                    <td>Nome
                        <input class="form-control" type="text" name="nome" placeholder="Nome" required>
                    </td>
                    <td>SIAPE
                        <input class="form-control" type="number" name="SIAPE" placeholder="SIAPE" required>
                    </td>
                    <td>E-mail
                        <input class="form-control" type="text" name="email" placeholder="E-mail" required>
                    </td>
                </tr>
                <tr>
                    <td>Telefone fixo
                        <input class="form-control" type="number" name="fixo" placeholder="Fixo" required>
                    </td>
                    <td>Celular
                        <input class="form-control" type="number" name="celular" placeholder="Celular" required>
                    </td>
                </tr>
                <tr>
                    <td><h4>Dados de entrada no sistema</h4></td>
                </tr>
                <tr>
                    <td>Login
                        <input class="form-control" type="text" name="login" placeholder="Login" required>
                    </td>
                    <td>Senha
                        <input class="form-control" type="text" name="senha" placeholder="Senha" required>
                    </td>
                    <td><br>
                        <input type="hidden" name="opcao" id="opcao" value="<?=Constantes::CADASTRAR_ADMINISTRADOR?>">
                        <button class="btn btn-success" type="submit" value="Cadastrar Administrador">
                            <span class="glyphicon glyphicon-save"></span>
                            Cadastrar
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>