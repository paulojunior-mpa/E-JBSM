<?
$permissao = array("administrador");
include 'functions/permitir.php';
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Tabela de edição de disponibilidade de monitores</h3>

        <form action="controller/Controller.php" method="post">
            <table class="table table-bordered" style="text-align: center">
                <tr>
                    <td>#</td>
                    <td>Segunda</td>
                    <td>Terça</td>
                    <td>Quarta</td>
                    <td>Quinta</td>
                    <td>Sexta</td>
                    <td rowspan="3">
                        <button type="submit" class="btn btn-warning" name="opcao" value="Alterar disponibilidade">
                            <span class="glyphicon glyphicon-edit"></span>
                            Alterar
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Manhã</td>
                    <td><input type="checkbox" name="manha_segunda" value="1"></td>
                    <td><input type="checkbox" name="manha_terca" value="1"></td>
                    <td><input type="checkbox" name="manha_quarta" value="1"></td>
                    <td><input type="checkbox" name="manha_quinta" value="1"></td>
                    <td><input type="checkbox" name="manha_sexta" value="1"></td>
                </tr>
                <tr>
                    <td>Tarde</td>
                    <td><input type="checkbox" name="tarde_segunda" value="1"></td>
                    <td><input type="checkbox" name="tarde_terca" value="1"></td>
                    <td><input type="checkbox" name="tarde_quarta" value="1"></td>
                    <td><input type="checkbox" name="tarde_quinta" value="1"></td>
                    <td><input type="checkbox" name="tarde_sexta" value="1"></td>
                </tr>
            </table>
        </form>
        <h3>Tabela de disponibilidade de monitores</h3>
        <?
        $sql = "select * from ejbsm_horarios_monitores where id = '1'";
        $result = $link->query($sql);
        while ($r = mysqli_fetch_object($result)) {
            ?>
            <table class="table" style="text-align: center;">
                <tr>
                    <td style="width: 10%;"></td>
                    <td style="width: 18%;"><font size="4" color="#556b2f">Segunda</font></td>
                    <td style="width: 18%;"><font size="4" color="#556b2f">Terça</font></td>
                    <td style="width: 18%;"><font size="4" color="#556b2f">Quarta</font></td>
                    <td style="width: 18%;"><font size="4" color="#556b2f">Quinta</font></td>
                    <td style="width: 18%;"><font size="4" color="#556b2f">Sexta</font></td>
                </tr>
                <tr>
                    <td><font size="4" color="#556b2f">Manhã</font></td>
                    <td>
                        <? if ($r->manha_segunda == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <? if ($r->manha_terca == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <? if ($r->manha_quarta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <? if ($r->manha_quinta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <? if ($r->manha_sexta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td><font size="4" color="#556b2f">Tarde</font></td>
                    <td>
                        <? if ($r->tarde_segunda == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <? if ($r->tarde_terca == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <? if ($r->tarde_quarta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <? if ($r->tarde_quinta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <? if ($r->tarde_sexta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                </tr>
            </table>
        <? } ?>
        <h3>Informações</h3>

        <form action="controller/Controller.php" method="post">
            <?
            $sql = "select * from ejbsm_informacao WHERE id = 1";
            $result = $link->query($sql);
            $linha = mysqli_fetch_object($result);
            ?>
            <table class="table">
                <tr>
                    <td>Neome da unidade/empresa
                        <input type="text" class="form-control" name="nome" placeholder="Nome"
                               value="<?= $linha->nome ?>" required="">
                    </td>
                    <td>Insituição pertencente
                        <input type="text" class="form-control" name="instituicao" placeholder="Instuição"
                               value="<?= $linha->instituicao ?>" required="">
                    </td>
                </tr>
                <tr>
                    <td>Fone para contato 1
                        <input type="text" class="form-control" name="fone1" placeholder="Fone 1"
                               value="<?= $linha->fone1 ?>" required="">
                    </td>
                    <td>Fone para contato 2
                        <input type="text" class="form-control" name="fone2" placeholder="Fone 2"
                               value="<?= $linha->fone2 ?>" required="">
                    </td>
                </tr>
                <tr>
                    <td>E-mail para contato
                        <input type="text" class="form-control" name="email" placeholder="E-mail"
                               value="<?= $linha->email ?>" required="">
                    </td>
                    <td>Endereço
                        <input type="text" class="form-control" name="endereco" placeholder="Endereço"
                               value="<?= $linha->endereco ?>" required="">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Descrição sobre...
                        <textarea class="form-control" name="descricao" placeholder="Descrição"
                                  required=""><?= $linha->descricao ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Latitude
                        <input type="text" class="form-control" name="latitude" placeholder="latitude"
                               value="<?= $linha->latitude ?>" required="">
                    </td>

                    <td>Longitude
                        <input type="text" class="form-control" name="longitude" placeholder="longitude"
                               value="<?= $linha->longitude ?>" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" class="btn btn-success" name="opcao" value="Alterar informações">
                            <span class="glyphicon glyphicon-save"></span>
                            Salvar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <h3>Alterar logo do sistema (recomendado: 245x335)</h3>

        <form action="controller/Controller.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <img src="arquivos_imagem_sistema/logo.png" style="width: 245px; height: 335px;">
                    </td>
                    <td>
                        <input type="file" class="form-control" name="logo" required="">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-warning" name="opcao" value="Alterar logo">
                            <span class="glyphicon glyphicon-edit"></span>
                            Alterar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <h3>Alterar "fundo" do sistema (recomendado: 1920x720)</h3>

        <form action="controller/Controller.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td colspan="2">
                        <img src="arquivos_imagem_sistema/fundo.png" width="100%" height="450px;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="form-control" type="file" name="fundo" required="">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-warning" name="opcao" value="Alterar fundo">
                            <span class="glyphicon glyphicon-edit"></span>
                            Alterar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <h3>Alterar título de entrada do sistema</h3>

        <form action="controller/Controller.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td>
                        <input class="form-control" type="text" name="titulo" value="<?= $linha->titulo ?>" required="">
                    </td>
                    <td>
                        <button class="btn btn-warning" type="submit" name="opcao" value="Alterar titulo">
                            <span class="glyphicon glyphicon-edit"></span>
                            Alterar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>