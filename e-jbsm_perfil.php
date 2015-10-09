<?
$permissao = array("usuario", "administrador", "orientador", "bolsista");
include 'Func/permitir.php';

if ($user_permissao == "usuario")
    $sql = "select * from ejbsm_usuario where login = '$user_login'";
else
    $sql = "select * from ejbsm_usuario, ejbsm_integrante where ejbsm_integrante.login = ejbsm_usuario.login and ejbsm_usuario.login = '$user_login'";
$result = $link->query($sql) or die(mysqli_error($link));
$user = mysqli_fetch_object($result);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Sua imagem de perfil</h3>

        <div class="row">
            <div class="col-md-4">
                <?
                Imagem($user_login, 200);
                ?>
            </div>
            <div class="col-md-4">
                <form action="Servlet/Controller.php" enctype="multipart/form-data" method="post">
                    <button type="button" data-toggle="modal" data-target="#myModal">
                        Clique para alterar a imagem
                        <img src="arquivos_imagem_sistema/imagem.png" width="50" height="50">
                    </button>
                    <br>Caso sua imagem não se altere, recarregue a página.
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Alterar imagem (max 2mb)</h4>
                                </div>
                                <div class="modal-body" style="margin-left: 20px">
                                    <?
                                    Imagem($user_login, 200);
                                    ?>
                                    <input type="file" class="form-control" name="arquivo" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-success" value="Alterar imagem"
                                            name="opcao">
                                        <span class="glyphicon glyphicon-camera"></span>
                                        Alterar imagem
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <h3>Dados pessoais</h3>

        <form action="Servlet/Controller.php" method="post" autocomplete="off">
            <div class="row">
                <div class="col-md-6">
                    Senha
                    <input type="password" class="form-control" name="senha" value=""
                           placeholder="Digite novamente sua senha ou crie uma nova"
                           required>
                    Nome
                    <input type="text" name="nome" class="form-control" value="<?= $user->nome ?>"
                           placeholder="Nome completo"
                           required>
                    E-mail
                    <input type="email" class="form-control" name="email" value="<?= $user->email ?>"
                           placeholder="E-mail"
                           required>
                    Cidade
                    <input type="text" class="form-control" name="cidade" value="<?= $user->cidade ?>"
                           placeholder="Cidade"
                           required>
                    Telefone fixo
                    <input type="number" class="form-control" name="fixo" value="<?= $user->fixo ?>"
                           placeholder="Fixo">
                    Celular
                    <input type="number" class="form-control" name="celular" value="<?= $user->celular ?>"
                           placeholder="Celular">
                </div>
                <div class="col-md-6">
                    <? if ($user->permissao != "usuario") {
                        if ($user->permissao == "bolsista") {
                            echo "Matricula";
                        } else {
                            echo "SIAPE";
                        }
                        ?>
                        <input type="number" class="form-control" name="id" value="<?= $user->id ?>" required>
                        CPF
                        <input type="text" class="form-control" name="cpf" value="<?= $user->cpf ?>" placeholder="CPF">
                        Registro Geral
                        <input type="number" class="form-control" name="rg" value="<?= $user->rg ?>"
                               placeholder="Registro Geral">
                        Órgão expedidor
                        <input type="text" class="form-control" name="orgao" value="<?= $user->orgao ?>"
                               placeholder="Órgão">
                    <? } ?>
                </div>
            </div>
            <? if ($user->permissao == "bolsista") { ?>
                <h3>Conta bancária</h3>
                <div class="row">
                    <div class="col-md-6">
                        Conta bancária
                        <input type="text" class="form-control" name="conta" value="<?= $user->conta ?>"
                               placeholder="Conta">
                        Banco
                        <input type="text" class="form-control" name="banco" value="<?= $user->banco ?>"
                               placeholder="Banco">
                    </div>
                    <div class="col-md-6">
                        Agência bancária
                        <input type="text" class="form-control" name="agencia" value="<?= $user->agencia ?>"
                               placeholder="Agência">
                        Tipo de conta
                        <select name="tipoConta" class="form-control">
                            <option value="Corrente">Corrente</option>
                            <option value="Poupanca">Poupança</option>
                        </select>
                    </div>
                </div>
                <h3>Horários</h3>
                <? $login_usuario = $user->login;
                include 'e-jbsm_bolsista_horario.php'; ?>
            <? } ?>
            <hr>
            <button type="submit" class="btn btn-success" value="Editar perfil" name="opcao">
                <span class="glyphicon glyphicon-save"></span>
                Salvar alterações
            </button>
        </form>
    </div>
</div>