<?php
isUserInRole(array("administrador"));
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Tabela de edição de disponibilidade de monitores</h3>
        <form action="controller/SystemController.php" method="post">
            <table class="table table-bordered" style="text-align: center">
                <tr>
                    <td>#</td>
                    <td>Segunda</td>
                    <td>Terça</td>
                    <td>Quarta</td>
                    <td>Quinta</td>
                    <td>Sexta</td>
                    <td rowspan="3">
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::ALTERAR_DISPONIBILIDADE?>">
                        <button type="submit" class="btn btn-warning" value="Alterar">
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
        <?php
        $sql = "select * from ejbsm_horarios_monitores where id = '1'";
        $result = $link->query($sql);
        while ($r = mysqli_fetch_object($result)) {
            ?>
            <table class="table" style="text-align: center;">
                <tr>
                    <td style="width: 10%;"></td>
                    <td style="width: 18%;"><div size="4" color="#556b2f">Segunda</div></td>
                    <td style="width: 18%;"><div size="4" color="#556b2f">Terça</div></td>
                    <td style="width: 18%;"><div size="4" color="#556b2f">Quarta</div></td>
                    <td style="width: 18%;"><div size="4" color="#556b2f">Quinta</div></td>
                    <td style="width: 18%;"><div size="4" color="#556b2f">Sexta</div></td>
                </tr>
                <tr>
                    <td><div size="4" color="#556b2f">Manhã</div></td>
                    <td>
                        <?php if ($r->manha_segunda == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <?php if ($r->manha_terca == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <?php if ($r->manha_quarta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <?php if ($r->manha_quinta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <?php if ($r->manha_sexta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td><div size="4" color="#556b2f">Tarde</div></td>
                    <td>
                        <?php if ($r->tarde_segunda == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <?php if ($r->tarde_terca == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <?php if ($r->tarde_quarta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <?php if ($r->tarde_quinta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                    <td>
                        <?php if ($r->tarde_sexta == 1) {
                            echo "<img src='arquivos_imagem_sistema/certo.png'>";
                        } else {
                            echo "<img src='arquivos_imagem_sistema/errado.png'>";
                        } ?>
                    </td>
                </tr>
            </table>
        <?php } ?>
        <h3>Informações</h3>

        <form action="controller/SystemController.php" method="post">
            <?php
            $sql = "select * from ejbsm_informacao WHERE id = 1";
            $result = $link->query($sql);
            $linha = mysqli_fetch_object($result);
            ?>
            <table class="table">
                <tr>
                    <td>Nome da unidade/empresa
                        <input type="text" class="form-control" name="nome" placeholder="Nome"
                               value="<?php echo  $linha->nome ?>" required="">
                    </td>
                    <td>Insituição pertencente
                        <input type="text" class="form-control" name="instituicao" placeholder="Instuição"
                               value="<?php echo  $linha->instituicao ?>" required="">
                    </td>
                </tr>
                <tr>
                    <td>Fone para contato 1
                        <input type="text" class="form-control" name="fone1" placeholder="Fone 1"
                               value="<?php echo  $linha->fone1 ?>" required="">
                    </td>
                    <td>Fone para contato 2
                        <input type="text" class="form-control" name="fone2" placeholder="Fone 2"
                               value="<?php echo  $linha->fone2 ?>" required="">
                    </td>
                </tr>
                <tr>
                    <td>E-mail para contato
                        <input type="text" class="form-control" name="email" placeholder="E-mail"
                               value="<?php echo  $linha->email ?>" required="">
                    </td>
                    <td>Endereço
                        <input type="text" class="form-control" name="endereco" placeholder="Endereço"
                               value="<?php echo  $linha->endereco ?>" required="">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Descrição sobre...
                        <textarea class="form-control" name="descricao" placeholder="Descrição"
                                  required=""><?php echo  $linha->descricao ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Latitude
                        <input type="text" class="form-control" name="latitude" placeholder="latitude"
                               value="<?php echo  $linha->latitude ?>" required="">
                    </td>

                    <td>Longitude
                        <input type="text" class="form-control" name="longitude" placeholder="longitude"
                               value="<?php echo  $linha->longitude ?>" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::ALTERAR_INFORMACOES?>">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-save"></span>
                            Salvar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <h3>Alterar logo do sistema (recomendado: 245x335)</h3>

        <form action="controller/SystemController.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <img src="arquivos_imagem_sistema/logo.png" style="width: 245px; height: 335px;">
                    </td>
                    <td>
                        <input type="file" class="form-control" name="logo" required="">
                    </td>
                    <td>
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::ALTERAR_LOGO?>">
                        <button type="submit" class="btn btn-warning" value="Alterar logo">
                            <span class="glyphicon glyphicon-edit"></span>
                            Alterar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <h3>Alterar "fundo" do sistema (recomendado: 1920x720)</h3>

        <form action="controller/SystemController.php" method="post" enctype="multipart/form-data">
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
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::ALTERAR_FUNDO?>">
                        <button type="submit" class="btn btn-warning">
                            <span class="glyphicon glyphicon-edit"></span>
                            Alterar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
        <h3>Alterar título de entrada do sistema</h3>

        <form action="controller/SystemController.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td>
                        <input class="form-control" type="text" name="titulo" value="<?php echo  $linha->titulo ?>" required="">
                    </td>
                    <td>
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::ALTERAR_TITULO?>">
                        <button class="btn btn-warning" type="submit">
                            <span class="glyphicon glyphicon-edit"></span>
                            Alterar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>