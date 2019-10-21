<?php
isUserInRole(array("administrador", "orientador"));
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Editar dados de bolsista</h3>
        <form action="controller/SystemController.php" method="post">
            <?php
            if(isset($_POST["bolsista_login"])) {
                $bolsista_login = $_POST["bolsista_login"];
            }
            $consulta = "select * from ejbsm_usuario, ejbsm_integrante where ejbsm_integrante.login = '$bolsista_login' and ejbsm_usuario.login=ejbsm_integrante.login";
            $resultado = $link->query($consulta) or die(mysqli_error($link));
            $user = mysqli_fetch_object($resultado);
            ?>
            <table class="table table-hover">
                <tr>
                    <td>
                        <b>Dados</b>
                    </td>
                    <td>
                        <b>Valores Atuais</b>
                    </td>
                    <td>
                        <b>Novos Valores</b>
                    </td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td><?php echo $user->nome; ?></td>
                    <td colspan="2"><input type="text" class="form-control" value="<?php echo $user->nome; ?>" name="nome" required></td>
                </tr>
                <tr>
                    <td>Matricula:</td>
                    <td><?php echo $user->id; ?></td>
                    <td><input type="number" class="form-control" value="<?php echo $user->id; ?>" name="matricula" required></td>
                </tr>
                <tr>
                    <script>
                        function setText() {
                            var x = document.getElementById('select1')
                            value = x.options[x.selectedIndex].value
                            if (value == 'Sim') {
                                campo1.innerHTML = "<input type='password' placeholder='inisra a senha...' class='form-control' name='senha'>"
                            }
                            else {
                                campo1.innerHTML = "";
                            }
                        }
                    </script>
                    <td>Alterar senha?</td>
                    <td>
                        <select class="form-control" onChange='setText()' id='select1'>
                            <option>Não</option>
                            <option>Sim</option>
                        </select>
                    </td>
                    <td id="campo1">

                    </td>
                </tr>
                <tr>
                    <td>Área de atuação:</td>
                    <td><?php echo $user->area; ?></td>
                    <td><input type="text" class="form-control" value="<?php echo $user->area; ?>" name="area" required></td>
                </tr>
                <tr>
                    <td>Ênfase:</td>
                    <td><?php echo $user->subarea; ?></td>
                    <td><input type="text" class="form-control" value="<?php echo $user->subarea; ?>" name="subarea" required></td>
                </tr>
                <tr>
                    <td>Projeto:</td>
                    <td><?php echo $user->projeto; ?></td>
                    <td><textarea cols="60" class="form-control" rows="3" name="projeto"
                                  required><?php echo $user->projeto; ?></textarea></td>
                </tr>
                <tr>
                    <td>Bolsa</td>
                    <td><?php echo $user->bolsa; ?></td>
                    <td>
                        <select name="bolsa" class="form-control" required>
                            <option value="PRAE">PRAE</option>
                            <option value="FIEX">FIEX</option>
                            <option value="Sem bolsa">Sem bolsa</option>
                            <option value="Outra">Outra</option>
                        </select>
                    </td>
                </tr>
                <!-- sdds -->
                <tr>
                    <td>E-mail:</td>
                    <td><?php echo $user->email; ?></td>
                    <td><input type="email" class="form-control" value="<?php echo $user->email; ?>" name="email" required></td>
                </tr>
                <tr>
                    <td>Fixo:</td>
                    <td><?php echo $user->fixo; ?></td>
                    <td><input type="tel" class="form-control" value="<?php echo $user->fixo; ?>" name="fixo" required></td>
                </tr>
                <tr>
                    <td>Celular:</td>
                    <td><?php echo $user->celular; ?></td>
                    <td><input type="text" class="form-control" value="<?php echo $user->celular; ?>" name="celular" required></td>
                </tr>
                <tr>
                    <td>RG:</td>
                    <td><?php echo $user->rg; ?></td>
                    <td><input type="text" class="form-control" value="<?php echo $user->rg; ?>" name="rg" required></td>
                </tr>
                <tr>
                    <td>Orgão:</td>
                    <td><?php echo $user->orgao; ?></td>
                    <td><input type="text" class="form-control" value="<?php echo $user->orgao; ?>" name="orgao" required></td>
                </tr>
                <tr>
                    <td>CPF:</td>
                    <td><?php echo $user->cpf; ?></td>
                    <td><input type="text" class="form-control" value="<?php echo $user->cpf; ?>" name="cpf" required></td>
                </tr>
                <tr>
                    <td>Conta:</td>
                    <td><?php echo $user->conta; ?></td>
                    <td><input type="text" class="form-control" value="<?php echo $user->conta; ?>" name="conta" required></td>
                </tr>
                <tr>
                    <td>Banco:</td>
                    <td><?php echo $user->banco; ?></td>
                    <td><input type="text" class="form-control" value="<?php echo $user->banco; ?>" name="banco" required></td>
                </tr>
                <tr>
                    <td>Agência:</td>
                    <td><?php echo $user->agencia; ?></td>
                    <td><input type="text" class="form-control" value="<?php echo $user->agencia; ?>" name="agencia" required></td>
                </tr>
                <tr>
                    <td>Tipo de Conta</td>
                    <td><?php echo $user->tipo_conta; ?></td>
                    <td>
                        <select name="tipoconta" class="form-control" required>
                            <option value="Corrente">Corrente</option>
                            <option value="Poupança">Poupança</option>
                            <option value="Outra">Outra</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td><?php echo $user->status == 1? 'Ativo':'Inativo'; ?></td>
                    <td>
                        <select name="status" class="form-control" required>
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php $login_usuario=$user->login;
                        include 'e-jbsm_bolsista_horario.php';?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="loginBolsista" value="<?php echo $bolsista_login ?>">
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::EDITAR_BOLSISTA?>">
                        <button type="submit" class="btn btn-success">
                            Salvar
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>