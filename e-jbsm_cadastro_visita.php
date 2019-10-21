<?php
isUserInRole(array("usuario", "administrador", "orientador", "bolsista"));
;

$inicio_consulta = "";
$info = "";
if (isset($_GET["inicio_consulta"])) {
    $inicio_consulta = $_GET["inicio_consulta"];
}
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<ul class="nav nav-tabs" role="tablist" id="cadastro">
    <li role="presentation" class="active"><a href="">Cadastro de visita</a></li>
    <li role="presentation"><a href="e-jbsm_lista_visitas.php">Lista de visitas</a></li>
</ul>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="alert alert-info" role="alert">
            <table>
                <tr>
                    <td>
                        Bem vindo(a) ao agendamento de visitas do e-jbsm.
                        Este espaço é destinado ao cadastramento de novas visitas ao Jardim Botânico da Universidade
                        Federal de
                        Santa Maria.
                        Disponibilizamos o horário dos nossos monitores e um calendário com as visitações já agendadas.
                        Ressaltamos que a visita pode ser realizada sem a presença do monitor, de segunda a sexta-feira,
                        das
                        08h00 às 17h00.
                        Após o cadastramento da visita, nossos monitores confirmarão o agendamento entrando em contato
                        com o
                        responsável cadastrado.
                        Havendo dúvidas no preenchimento nos contate pelo número (55) 3220-8339, ramais 222 e 225.
                    </td>
                </tr>
            </table>
        </div>
        <?php
        $sql = "select * from ejbsm_horarios_monitores where id = 1";
        $result = $link->query($sql);
        while ($r = mysqli_fetch_object($result)) {
            ?>
            <h3>Tabela de disponibilidade dos monitores para acompanhamento:</h3>
            <table class="table table-bordered">
                <tr>
                    <td style="width: 10%;">#</td>
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
        <?php }
        $data = "";
        if (isset($_GET["data"])) {
            $data = $_GET["data"];
            $i = 1;
            $sql = "select * from ejbsm_visita WHERE status = 'Confirmada' AND data = '$data'";
            $result = $link->query($sql) or die(mysqli_error($link));
            echo "Visitas para o dia <b>$data</b><br>";

            while ($row = mysqli_fetch_object($result)) {
                echo "<br><b>Visita $i</b><br>";
                echo "<b>Instituição:</b> $row->instituicao<br>";
                echo "<b>Hora de inicio:</b> $row->hora<br>";
                echo "<b>Duração da visita:</b> $row->duracao<br>";
                $i++;
            }
            if ($i == 1) {
                echo "Nenhuma visita.";
            }
        }
        ?>
        <br>
        <button type="button" class="btn btn-warning"
                data-toggle="modal"
                data-target="#myModal">
            <span class="glyphicon glyphicon-calendar"></span>
            Clique aqui para ver o calendário de visistas.
        </button>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1"
             role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal"
                                aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            Calendário anual de visitas.</h4>
                    </div>
                    <div class="modal-body">
                        <?php include 'e-jbsm_calendario_.php' ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <h3>Cadastro de visita</h3>

        <div class="panel-body" id="cadastrada">
            <?php if ($info == "cadastrada") { ?>
                <div class="alert alert-info" role="alert">Visita cadastrada!</div>
            <?php } ?>
        </div>
        <form action="controller/SystemController.php" method="post">
            <h4>1º - Dados dos visitantes</h4>

            <div class="row">
                <div class="col-md-6">
                    Nome da instituição/ Grupo
                    <input type="text" class="form-control" placeholder="Instituição" name="visita_instituicao"
                           required="">
                    Tipo de instituição
                    <select name="visita_tipo_instituicao" required class="form-control">
                        <option value="Publica">Pública</option>
                        <option value="Privada">Privada</option>
                        <option value="Outra">Outra</option>
                    </select>
                    Cidade dos visitantes
                    <input type="text" class="form-control" placeholder="Cidade" required="" name="visita_cidade">
                </div>
                <div class="col-md-6">
                    Número de visitantes
                    <input type="number" class="form-control" placeholder="Somente números" required=""
                           name="visita_numero_visitantes">
                    Curso/Ano dos visitantes
                    <input type="text" class="form-control" placeholder="Curso/Ano" name="visita_curso">
                </div>
            </div>
            <h4>2º - Dados da visita</h4>

            <div class="row">
                <div class="col-md-6">
                    Oficina (<a target="_blank" href="e-jbsm_oficinas.php">Listar
                        Oficinas</a>)
                    <select name="visita_oficina" required="" class="form-control">
                        <option value="Não">Não</option>
                        <?php
                        $sql = "select * from ejbsm_oficina";
                        $result = $link->query($sql);
                        while ($row = mysqli_fetch_object($result)) {
                            echo "<option value='$row->nome'>$row->nome</option>";
                        }
                        ?>
                    </select>
                    Data da visita
                    <input type="date" class="form-control" required="" name="visita_data">
                    Hora da visita
                    <input type="time" class="form-control" required="" name="visita_hora">
                    Duração da visita
                    <input type="time" class="form-control" required="" name="visita_duracao">
                    Presença de monitor
                    <select name="visita_monitor" required class="form-control">
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <script>
                        function setText() {
                            var x = document.getElementById('select1')
                            value = x.options[x.selectedIndex].value
                            if (value == 'sim') {
                                campo1.innerHTML = "Conteúdo <input type='text' class='form-control' placeholder='descreva o conteudo' required='' name='visita_conteudo'>"
                            }
                            else {
                                campo1.innerHTML = "";
                            }
                        }
                    </script>
                    Existe algum conteúdo planejado?
                    <select required class="form-control" id="select1" onChange='setText()'>
                        <option value="nao">Não</option>
                        <option value="sim">Sim</option>
                    </select>

                    <div id="campo1">
                    </div>
                    Auxílio para desenvolver um conteúdo?
                    <select name="visita_auxilio_conteudo" required class="form-control">
                        <option value="nao">Não</option>
                        <option value="sim">Sim</option>
                    </select>
                    Nome do responsável pela visita
                    <input type="text" class="form-control" placeholder="Nome" required=""
                           name="visita_responsavel">
                    Telefone para contato
                    <input type="number" class="form-control" placeholder="Somente números" name="visita_fone">
                    <?php if ($user_permissao != "usuario") { ?>
                        Plano de visitação
                        <select name="visita_plano" required class="form-control">
                            <?php

                            $sql = "select * from ejbsm_plano;";
                            $qr = $link->query($sql);
                            while ($r = mysqli_fetch_object($qr)) {
                                ?>
                                <option value="<?php echo $r->nome ?>"><?php echo "$r->nome"; ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                    <hr>
                </div>
            </div>
            <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::CADASTRAR_VISITA?>">
            <button class='btn btn-success' type="submit" class="form-control">
                <span class="glyphicon glyphicon-save"></span>
                Cadastrar visita
            </button>
        </form>
    </div>
</div>