<?php
isUserInRole(array("administrador", "orientador", "bolsista"));

if(isset($_POST["id"])) {
    $id = $_POST["id"];
    $sql = "select * from ejbsm_visita where id = '$id'";
    $result = $link->query($sql);
    $visita = mysqli_fetch_object($result);
}
?>
<form action="controller/SystemController.php" method="post">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Edição de visita</h3>
            <table class="table table-hover">
                <tr>
                    <td><b>Colunas</b></td>
                    <td><b>Dados atuais</b></td>
                    <td><b>Novos dados</b></td>
                </tr>
                <tr>
                    <td>Nome da insituição/Grupo</td>
                    <td><?php echo $visita->instituicao?></td>
                    <td><input type="text" class="form-control" value="<?php echo $visita->instituicao?>"
                               placeholder="Instituição" name="visita_instituicao" required=""></td>
                </tr>
                <tr>
                    <td>Tipo de instituição</td>
                    <td><?php echo $visita->tipo_instituicao?></td>
                    <td>
                        <select name="visita_tipo_instituicao" class="form-control" required>
                            <option value="Publica">Pública</option>
                            <option value="Privada">Privada</option>
                            <option value="Outra">Outra</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Cidade dos visitantes</td>
                    <td><?php echo $visita->cidade?></td>
                    <td>
                        <input type="text" class="form-control" value="<?php echo $visita->cidade?>" placeholder="Cidade"
                               required="" name="visita_cidade">
                    </td>
                </tr>
                <tr>
                    <td>Número de visitantes</td>
                    <td><?php echo $visita->visitantes?></td>
                    <td>
                        <input type="text" class="form-control" value="<?php echo $visita->visitantes; ?>"
                               placeholder="Número" required="" name="visita_numero_visitantes">
                    </td>
                </tr>
                <tr>
                    <td>Curso/Ano dos visitantes</td>
                    <td><?php echo $visita->curso?></td>
                    <td>
                        <input type="text" class="form-control" value="<?php echo $visita->curso?>" placeholder="Curso/Ano"
                               name="visita_curso">
                    </td>
                </tr>
                <tr>
                    <td>Oficina</td>
                    <td><?php echo $visita->oficina?></td>
                    <td>
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
                    </td>
                </tr>
                <tr>
                    <td>Data da visita</td>
                    <td><?php echo $visita->data?></td>
                    <td>
                        <input type="date" class="form-control" value="<?php echo $visita->data?>" required=""
                               name="visita_data">
                    </td>
                </tr>
                <tr>
                    <td>Hora da visita</td>
                    <td><?php echo $visita->hora; ?></td>
                    <td>
                        <input type="time" class="form-control" value="<?php echo $visita->hora?>" required=""
                               name="visita_hora">
                    </td>
                </tr>
                <tr>
                    <td>Duração da visita</td>
                    <td><?php echo $visita->duracao?></td>
                    <td>
                        <input type="time" class="form-control" value="<?php echo $visita->duracao?>" required=""
                               name="visita_duracao">
                    </td>
                </tr>
                <tr>
                    <td>Monitor</td>
                    <td><?php echo $visita->monitor?></td>
                    <td>
                        <select name="visita_monitor" class="form-control" required>
                            <?php
                            $sql = "select * from ejbsm_usuario, ejbsm_integrante WHERE ejbsm_usuario.login = ejbsm_integrante.login and monitor AND status != 0";
                            $result = $link->query($sql);
                            while ($row = mysqli_fetch_object($result)) {
                                $nome = explode(" ", $row->nome);
                                echo "<option value='$row->login'>$nome[0] / $row->login</option>";
                            } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Deseja auxílio para desenvolver um conteudo?</td>
                    <td><?php echo $visita->auxilio?></td>
                    <td>
                        <select name="visita_auxilio_conteudo" class="form-control" required>
                            <option value="nao">Não</option>
                            <option value="sim">Sim</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Caso exista um conteúdo qual seria?</td>
                    <td><?php echo $visita->conteudo?></td>
                    <td>
                        <input type="text" class="form-control" value="<?php echo $visita->conteudo?>"
                               placeholder="conteúdo..." required="" name="visita_conteudo">
                    </td>
                </tr>
                <tr>
                    <td>Nome do responsável pela visita</td>
                    <td><?php echo $visita->responsavel?></td>
                    <td>
                        <input type="text" class="form-control" value="<?php echo $visita->responsavel?>"
                               placeholder="Nome"
                               required="" name="visita_responsavel">
                    </td>
                </tr>
                <tr>
                    <td>Telefone para contato</td>
                    <td><?php echo $visita->fone?></td>
                    <td>
                        <input type="tel" class="form-control" value="<?php echo $visita->fone?>" placeholder="Telefone"
                               name="visita_fone">
                    </td>
                </tr>
                <tr>
                    <td>Plano de visitação</td>
                    <td><?php echo $visita->plano?></td>
                    <td>
                        <select name="visita_plano" class="form-control" required>
                            <?php
                            $sql = "select * from ejbsm_plano;";
                            $qr = $link->query($sql);
                            while ($r = mysqli_fetch_object($qr)) {
                                ?>
                                <option value="<?php echo $r->nome ?>"><?php echo "$r->nome"; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Status da visita</td>
                    <td><?php echo $visita->status?></td>
                    <td>
                        <select name="visita_status" class="form-control" required>
                            <option value="Confirmada">Confirmar</option>
                            <option value="Em espera">Deixar em Espera</option>
                            <option value="Cancelada">Cancelar</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input type="hidden" class="form-control" name="visita_login" value="<?php echo $visita->login ?>">
                        <input type="hidden" class="form-control" name="visita_id" value="<?php echo $visita->id ?>">
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::EDITAR_VISITA?>">
                        <button type="submit" class="btn btn-success btn-block">
                            Salvar
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>