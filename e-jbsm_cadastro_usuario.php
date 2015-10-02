<?php
include 'Service/Conexao.php';
include 'e-jbsm_cabecalho.php';
$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
$usuario = array('login' => "", 'senha' => "", 'nome' => "", 'email' => "", 'fixo' => "", 'celular' => "", 'cidade' => "", 'horario' => "");
if (isset($_REQUEST["usuario"])) {
    $usuario = json_decode($_REQUEST["usuario"], true);
}
?>
<script>
    function formatar(mascara, documento) {
        var i = documento.value.length;
        var saida = mascara.substring(0, 1);
        var texto = mascara.substring(i)

        if (texto.substring(0, 1) != saida) {
            documento.value += texto.substring(0, 1);
        }

    }
</script>
<div class="panel panel-default">
    <div class="panel-body">
        <form action="Servlet/Controller_public.php" method="post">
            <h1>Realize o seu cadastro</h1>
            <h4>Insira seus dados nos campos especificados</h4>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome">Nome completo</label>
                    <input type="text" class="form-control" id="nome" placeholder="Nome completo" required=""
                           name="usuario_nome" value="<?= $usuario['nome']; ?>">
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" class="form-control" placeholder="Cidade" name="usuario_cidade" id="cidade"
                           value="<?= $usuario['cidade']; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="celular">Telefone celular</label>
                    <input type="tel" id="celular" OnKeyPress="formatar('##-####-####', this)" maxlength="12"
                           class="form-control" required placeholder="xx-xxxx-xxxx"
                           name="usuario_celular"
                           value="<?= $usuario['celular']; ?>">
                    </td>
                </div>
                <div class="form-group">
                    <label for="fixo">Telefone fixo</label>
                    <input type="tel" OnKeyPress="formatar('##-####-####', this)" maxlength="12"
                           class="form-control" placeholder="xx-xxxx-xxxx" required name="usuario_fixo" id="fixo"
                           value="<?= $usuario['fixo']; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" placeholder="E-mail" required="" id="email"
                           name="usuario_email"
                           value="<?= $usuario['email']; ?>">
                </div>
            </div>
            <div class="col-md-12">
                <h4>Agora você deve inserir os dados que utilizará para logar no sistema futuramente</h4>
                Dica de login: use seu e-mail ou escolha uma palavra ou nome que seja facil de relembrar.
            </div>
            <div class="form-group col-md-6">
                <label for="login_user">Login</label>
                <input type="text" class="form-control" placeholder="insira seu login desejado" id="login_user"
                       required="" name="usuario_login" value="<?= $usuario['login'] ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" placeholder="insira a senha" required="" id="senha"
                       name="usuario_senha" value="<?= $usuario['senha'] ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="repita_senha">Repita a senha</label>
                <input type="password" class="form-control" id="repita_senha"
                       placeholder="insira a senha novamente" required=""
                       name="usuario_confirma_senha">
            </div>
            <div class="form-group col-md-6"><br>
                <button class='btn btn-success' type="submit" style="width: 100%" class="form-control"
                        name="opcao" value="Cadastrar usuario"
                        name="usuario_nome">
                    <span class="glyphicon glyphicon-save"></span>
                    Cadastrar
                </button>
            </div>
            <div class="col-md-12">
                <h5>A senha que você cadastrar será salva usando o algorítimo de
                    criptografia SHA-1 (Secure Hash Algorithm), logo não pode ser recuperada em sua forma
                    original.<br>
                    Caso esqueça sua senha, você pode pedir a redefinição desta por meio do e-mail cadastrado utilizando
                    o seu login.
                </h5>
            </div>
        </form>
    </div>
    <? if ($info == "senha") { ?>
        <div class="alert alert-danger" role="alert">As senhas não são iguais, pro favor insira novamente a
            senha e a confirme.
        </div>
    <? } elseif ($info == "login") { ?>
        <div class="alert alert-danger" role="alert">O login digitado já existe, tente outro.</div>
    <? } elseif ($info == "cadastrado") { ?>
        <div class="alert alert-success" role="alert">Usuario cadastrado! Você será redirecionado em 5
            segundos
        </div>
        <meta http-equiv="refresh" content="5; url=index.php?info=cadastrado">
    <? } ?>
</div>