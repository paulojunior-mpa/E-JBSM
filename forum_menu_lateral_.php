<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
                $sql = "select nome, email from ejbsm_usuario where login = '$user_login'";
                $row = mysqli_fetch_object($link->query($sql));
                $nome = explode(" ", $row->nome);
                $user_email = $row->email;
                function imagemMenu($login, $max)
                {
                    $x = 100;
                    if (file_exists("arquivos_imagem_perfil/$login.jpg")) {
                        chmod("arquivos_imagem_perfil/$login.jpg", 0755);
                        list($largura, $altura) = getimagesize("arquivos_imagem_perfil/$login.jpg");

                        $x = ($altura * $max) / $largura;

                        echo "<a href='e-jbsm_perfil.php'><img class='img-thumbnail' src='arquivos_imagem_perfil/$login.jpg' width='$max' height='$x'></a>";
                    } else {
                        echo "<a href='e-jbsm_perfil.php'><img class='img-thumbnail' src='arquivos_imagem_perfil/user.png' width='$max' height='$x'></a>";
                    }
                }
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <?php imagemMenu($user_login, 80);?>
                    </div>
                    <div class="col-md-8">
                        Nome: <?php echo$nome[0];?><br>
                        Permissões: <?php echo $user_permissao?>
                    </div>
                </div>
                <?php if ($user_permissao != "usuario") { ?>
                <h4>Links</h4>
                <ul id="sidebar" class="nav nav-pills nav-stacked" style="max-width: 200px;">
                    <li><a href="forum_index.php"><span class="glyphicon glyphicon-tag"></span> Tópicos</a></li>
                    <li><a href="forum_cadastro_topico.php"><span class="glyphicon glyphicon-pencil"></span> Novo tópico</a>
                    </li>
                    <li><a href="forum_info_area.php"><span class="glyphicon glyphicon-list"></span> Listar áreas</a>
                    </li>
                    <li><a href="forum_info_subarea.php"><span class="glyphicon glyphicon-list"></span> Listar subáreas</a>
                    </li>
                    <li><a href="forum_sugestao.php"><span class="glyphicon glyphicon-pencil"></span> Sugerir</a></li>
                </ul>

                <h4>Pesquisa por áreas e subareas</h4>
                <?php
                $sql = "select * from ejbsm_forum_area where status = 'ativa' ORDER by nome;";
                $qr = $link->query($sql) or die(mysqli_error($link));
                while ($area = mysqli_fetch_object($qr)) {
                    ?>
                    <div class="dropdown">
                        <button class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true" style="margin-bottom: 2px; text-align: left">
                            <span class="glyphicon glyphicon-menu-down"></span>
                            <?php echo $area->nome; ?>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                            <?php
                            $sql2 = "select * from ejbsm_forum_subarea where id_area = '$area->id' and status = 'ativa' order by nome;";
                            $qr2 = $link->query($sql2) or die(mysqli_error($link));
                            while ($sub = mysqli_fetch_object($qr2)) {
                                ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1"
                                       href="forum_index.php?subarea=<?php echo $sub->id ?>">
                                        <?php echo $sub->nome ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } }?>
            </div>
        </div>
    </div>
    <div class="col-md-9">