<div id='cssmenu'>
    <ul>
        <li class='active has-sub'>
            <a>
                <span>
                    <img style="margin-left: 20%" src="arquivos_imagem_sistema/pesquisar.png" width="30px"
                                 height="30px"> Clique aqui para pesquisar (preencha o que achar necessário)
                </span>
            </a>
            <ul>
                <li class='has-sub'>
                    <a>
                        <form action="forum_index.php" method="post">
                            <table class="table">
                                <tr>
                                    <td>Área
                                        <select name="pesquisa_area" class="form-control" onChange='setText()'
                                                id='option1'>
                                            <option value="">Todas</option>
                                            <?php
                                            $sql = "select * from ejbsm_forum_area  where status = 'ativa' order by nome asc;";
                                            $qr = $link->query($sql) or die(mysqli_error($link));
                                            while ($area = mysqli_fetch_object($qr)) {
                                                ?>
                                                <option value="<?= $area->id ?>"><?php echo $area->nome ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>Subárea
                                        <select name="pesquisa_subarea" class="form-control" id="subarea">
                                            <option value="">Todas</option>
                                            <?php
                                            $sql = "select * from ejbsm_forum_subarea  where status = 'ativa' order by nome asc;";
                                            $qr = $link->query($sql) or die(mysqli_error($link));
                                            while ($subarea = mysqli_fetch_object($qr)) {
                                                ?>
                                                <option
                                                    value="<?= $subarea->id ?>"><?php echo $subarea->nome ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Login de usuário
                                        <input type="text" class="form-control" name="pesquisa_nomeUser"
                                               placeholder="login do usuário">
                                    </td>
                                    <td>Assunto do tópico
                                        <input type="text" class="form-control" name="pesquisa_assunto"
                                               placeholder="assunto do tópico">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Conteúdo do tópico
                                        <input type="text" class="form-control" name="pesquisa_conteudo"
                                               placeholder="conteúdo do tópico">
                                    </td>
                                    <td>Data
                                        <input type="date" class="form-control" name="pesquisa_data">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="hidden" name="consulta" id="consulta" value="<?=Constantes::PESQUISAR?>">
                                        <button type="submit" class="btn btn-info">
                                            <span class="glyphicon glyphicon-search"></span>
                                            Pesquisar
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
