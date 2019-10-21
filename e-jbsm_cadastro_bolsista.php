<?php
isUserInRole(array("administrador", "orientador"));
$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Cadastro bolsista</h3>
        <form action="controller/SystemController.php" method="post">
            <?php if ($info == "cadastrado") { ?>
                <div class="alert alert-success" role="alert">Bolsista cadastrado!</div>
            <?php } elseif ($info == "login") { ?>
                <div class="alert alert-danger" role="alert">Este login já está cadastrado!</div>
            <?php } ?>
            <table class="table">
                <tr>
                    <td colspan="3">
                        <h4>Dados pessoais do bolsista.</h4>
                    </td>
                </tr>
                <tr>
                    <td>Nome
                        <input class="form-control" type="text" name="nome" placeholder="Nome" required>
                    </td>
                    <td>Matricula
                        <input class="form-control" type="number" name="matricula" placeholder="Matricula" required>
                    </td>
                    <td>E-mail
                        <input class="form-control" type="text" name="email" placeholder="E-mail" required>
                    </td>
                </tr>
                <tr>
                    <td>Telefone fixo
                        <input class="form-control" type="text" name="fixo" placeholder="Fixo">
                    </td>
                    <td>Celular
                        <input class="form-control" type="text" name="celular" placeholder="Celular">
                    </td>
                </tr>
                <tr>
                    <td>Registro Geral
                        <input class="form-control" type="text" name="rg" placeholder="RG">
                    </td>
                    <td>Orgão expedidor
                        <input class="form-control" type="text" name="orgao" placeholder="Órgão expedidor">
                    </td>
                    <td>CPF
                        <input class="form-control" type="text" name="cpf" placeholder="CPF">
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><h4>Dados de entrada no sistema.</h4></td>
                </tr>
                <tr>
                    <td>Login
                        <input class="form-control" type="text" name="login" placeholder="Login" required>
                    </td>
                    <td>Senha
                        <input class="form-control" type="password" name="senha" placeholder="Senha" required>
                    </td>
                </tr>
                <tr>
                    <td><h4>Dados da bolsa.</h4></td>
                </tr>
                <tr>
                    <td>Área
                        <input class="form-control" type="text" name="area" placeholder="Área" required>
                    </td>
                    <td>Ênfase
                        <input class="form-control" type="text" name="subArea" placeholder="Ênfase" required>
                    </td>
                    <td>Projeto
                        <textarea class="form-control" name="projeto" placeholder="Projeto" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Bolsa
                        <select class="form-control" name="bolsa">
                            <option value="PRAE">PRAE</option>
                            <option value="FIEX">FIEX</option>
                            <option value="Sem bolsa">Sem bolsa</option>
                            <option value="Outra">Outra</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><h4>Dados para pagamentos.</h4></td>
                </tr>
                <tr>
                    <td>Conta bancária
                        <input class="form-control" type="text" name="conta" placeholder="Conta">
                    </td>
                    <td>Agência bancária
                        <input class="form-control" type="text" name="agencia" placeholder="Agência">
                    </td>
                    <td>Banco
                        <input class="form-control" type="text" name="banco" placeholder="Banco">
                    </td>
                </tr>
                <tr>
                    <td>Tipo de conta
                        <select class="form-control" name="tipoConta">
                            <option value="Corrente">Corrente</option>
                            <option value="Poupanca">Poupança</option>
                        </select>
                    </td>
                    <td><br>
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::CADASTRAR_BOLSISTA?>">
                        <button class="btn btn-success" type="submit" value="Cadastrar bolsista">
                            <span class="glyphicon glyphicon-save"></span>
                            Cadastrar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>