<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta charset="utf-8">
    <title>E-JBSM</title>
    <!--Font Awesome-->
    <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link href="resources/css/bootstrap.min.css" rel="stylesheet">
    <link href="resources/css/styles.css" rel="stylesheet">
    <script src="resources/js/min.js" type="text/javascript"></script>
    <script src="resources/js/script.js"></script>
    <script src="resources/js/jquery.min.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>
    <script defer="defer" src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script>
</head>
<body>
<div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;">
    <ul id="menu-barra-temp" style="list-style:none;">
        <li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED">
            <a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal
                do Governo Brasileiro</a></li>
        <li><a style="font-family:sans,sans-serif; text-decoration:none; color:white;"
               href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a>
        </li>
    </ul>
</div>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <?php
                $caminho = "arquivos_imagem_sistema";
                if(!list($largura, $altura) = getimagesize('arquivos_imagem_sistema/logo.png')){
                    list($largura, $altura) = getimagesize('../arquivos_imagem_sistema/logo.png');
                    $caminho = "../arquivos_imagem_sistema";
                }
                $max = 30;
                $x = ($altura * $max) / $largura;
                echo "<img src='$caminho/logo.png' style='margin-top: -30%;' width='$max' height='$x'>";
                ?>
            </a>
        </div>
        <?php
        if (!isset($user_permissao)) {
            $user_permissao = "";
            $user_permissao = null;
            ?>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="e-jbsm_login.php"><span class="glyphicon glyphicon-home"></span> Login</a></li>
                    <li><a href="e-jbsm_cadastro_usuario.php"><span
                                class="glyphicon glyphicon-pencil"></span> Cadastro</a>
                    </li>
                    <li><a href="app.php"><span class="glyphicon glyphicon-qrcode"></span> E-GEA</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://w3.ufsm.br/jbsm/" target="_blank"><span class="glyphicon glyphicon-share-alt"></span>Site JBSM</a></li>
                    <li><a href="http://www.ufsm.br/smdb" target="_blank"><span class="glyphicon glyphicon-share-alt"></span> Herbário SMDB</a></li>
                    <li><a href="e-jbsm_sobre.php"><span class="glyphicon glyphicon-info-sign"></span> Sobre</a>
                </ul>
            </div>
        <?php
        } elseif ($user_permissao == "bolsista" or $user_permissao == "administrador" or $user_permissao == "orientador" or $user_permissao == "usuario") {

            if ($user_permissao == "usuario") {
                $sql2 = "select id from ejbsm_visita where login = '$user_login' and status = 'nao';";
                $result = $link->query($sql2) or die(mysqli_error($link));
                $contagem_visitas = mysqli_num_rows($result);
            } else {
                $sql = "select id from ejbsm_batepapo_mensagem;";
                $result = $link->query($sql) or die(mysqli_error($link));
                $contagem_mensagens = mysqli_num_rows($result);

                $sql2 = "select id from ejbsm_visita where excluida = 'nao';";
                $result = $link->query($sql2) or die(mysqli_error($link));
                $contagem_visitas = mysqli_num_rows($result);
            }
            ?>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="e-jbsm_home.php"><span
                                class="glyphicon glyphicon-home"></span> Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="glyphicon glyphicon-tags"></span> Visitas<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="e-jbsm_cadastro_visita.php"><span
                                        class="glyphicon glyphicon-pencil"></span> Cadastrar visita
                                </a>
                            </li>
                            <li>
                                <a href="e-jbsm_lista_visitas.php"><span
                                        class="glyphicon glyphicon-list"></span> Listar visitas
                                    <span class="badge"><?php echo $contagem_visitas ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="e-jbsm_relatorios_visita.php"><span
                                        class="glyphicon glyphicon-filter"></span> Relatórios
                                </a>
                            </li>
                            <li><a href="e-jbsm_sobre.php"><span class="glyphicon glyphicon-info-sign"></span> Sobre</a>
                        </ul>
                    </li>
                    <?php
                    if ($user_permissao != "usuario") { ?>
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown"><span
                                    class="glyphicon glyphicon-tags"></span> Atividades<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="e-jbsm_frequencia.php"><span
                                            class="glyphicon glyphicon-list"></span> Controle de freqûencia</a></li>
                                <li><a href="e-jbsm_lista_programacao.php"><span
                                            class="glyphicon glyphicon-list"></span>
                                        Programações</a></li>
                                <li><a href="e-jbsm_planos.php"><span
                                            class="glyphicon glyphicon-pencil"></span> Planos</a>
                                </li>
                                <li><a href="e-jbsm_oficinas.php"><span
                                            class="glyphicon glyphicon-pencil"></span>
                                        Oficinas</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown"><span
                                    class="glyphicon glyphicon-list"></span> Listar<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="e-jbsm_lista_bolsistas.php"><span
                                            class="glyphicon glyphicon-user"></span> Bolsistas</a></li>
                                <li><a href="e-jbsm_lista_orientadores.php"><span
                                            class="glyphicon glyphicon-user"></span> Orientadores</a></li>
                                <li><a href="e-jbsm_lista_administradores.php"><span
                                            class="glyphicon glyphicon-user"></span> Administradores</a></li>
                                <li><a href="e-jbsm_monitores.php"><span
                                            class="glyphicon glyphicon-user"></span> Monitores</a></li>
                                <li><a href="e-jbsm_lista_usuarios.php"><span
                                            class="glyphicon glyphicon-user"></span>
                                        Usuários</a>
                                </li>
                            </ul>
                        </li>
                        <?php if ($user_permissao != "bolsista") { ?>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="glyphicon glyphicon-pencil"></span> Cadastrar<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="e-jbsm_cadastro_bolsista.php"><span
                                                class="glyphicon glyphicon-user"></span> Bolsista</a></li>
                                    <?php if ($user_permissao == "administrador") { ?>
                                        <li><a href="e-jbsm_cadastro_orientador.php"><span
                                                    class="glyphicon glyphicon-user"></span> Orientador</a></li>
                                        <li><a href="e-jbsm_cadastro_administrador.php"><span
                                                    class="glyphicon glyphicon-user"></span> Administrador</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php
                        }
                        echo "<li><a href='e-jbsm_bate-papo.php'><span class='glyphicon glyphicon-send'></span>
                                Bate-papo <span class='badge'>$contagem_mensagens</span></a></li>";

                        $sql2 = "select id from ejbsm_visita where excluida != 'nao';";
                    } else {
                        $sql2 = "select id from ejbsm_visita where excluida != 'nao' AND login = '$user_login';";
                    }
                    $result = $link->query($sql2) or die(mysqli_error($link));
                    $contagem_visitas = mysqli_num_rows($result);
                    ?>
                    <li><a href="app.php"><span class="glyphicon glyphicon-qrcode"></span> E-GEA</a></li>
                    <li><a href="e-jbsm_lixeira.php"><span class="glyphicon glyphicon-trash"></span>Lixeira <span class="badge"><?php echo $contagem_visitas ?></span></a></li>
                    <li><a href="e-jbsm_sobre.php"><span class="glyphicon glyphicon-info-sign"></span> Sobre</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="glyphicon glyphicon-plus"></span> <?php echo $user_login ?><span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="e-jbsm_perfil.php">
                                    <button type="button" class="btn btn-default btn-lg">
                                        <span class="glyphicon glyphicon-user"></span>Seu perfil
                                    </button>
                                </a>
                            </li>
                            <?php if ($user_permissao == "administrador") { ?>
                                <li>
                                    <a href="adminer-4.7.3-mysql.php" target="_blank">
                                        <button type="button" class="btn btn-default btn-lg">
                                            <span class="glyphicon glyphicon-hdd"></span> Banco
                                        </button>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <button type="button" class="btn btn-default btn-lg"
                                                data-toggle="modal"
                                                data-target="#ModalSQL">
                                            <span class="glyphicon glyphicon-option-horizontal"></span>
                                            Comando
                                        </button>
                                    </a>
                                </li>
                                <li>
                                    <a href="e-jbsm_administracao.php">
                                        <button type="button" class="btn btn-default btn-lg">
                                            <span class="glyphicon glyphicon-wrench"></span> ADM
                                        </button>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="divider"></li>
                            <li>
                                <a href="controller/SystemController.php" methods="post">
                                    <button type="button" class="btn btn-danger btn-lg">
                                        <span class="glyphicon glyphicon-off"></span>Sair
                                    </button>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        <?php } ?>
    </div>
    <!-- /.container-fluid -->
</nav>
<div id="tela">
    <!-- Modal -->
    <div class="modal fade" id="ModalSQL" tabindex="-1"
         role="dialog"
         aria-labelledby="myModalSQL"
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
                        Insira a SQL:</h4>
                </div>
                <div class="modal-body">
                    <script>
                        function ExecutaSQL() {
                            var x = document.getElementById('sql');
                            var str = x.value;
                            var c = confirm("Deseja executar: "+str+"?");
                            if(c) {
                                if (str.length == 0) {
                                    document.getElementById("ComandoADM").innerHTML = "";
                                    return;
                                } else {
                                    var xmlhttp = new XMLHttpRequest();
                                    xmlhttp.onreadystatechange = function () {
                                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                            document.getElementById("ComandoADM").innerHTML = xmlhttp.responseText;
                                        }
                                    };
                                    xmlhttp.open("GET", "helpers/ajax_comando_adm.php?q=" + str, true);
                                    xmlhttp.send();
                                }
                            }
                        }
                    </script>
                    <input type="text" class="form-control" id="sql">
                    <div id="ComandoADM"></div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default"
                            data-dismiss="modal">Cancelar
                    </button>
                    <button type="submit" value="Excluir visita"
                            class="btn btn-warning" name="opcao" onclick="ExecutaSQL()">
                        <span class="glyphicon glyphicon-arrow-right"></span>
                        Executar
                    </button>
                </div>
            </div>
        </div>
    </div>