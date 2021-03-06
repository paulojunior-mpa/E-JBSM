<?php

isUserInRole(array("usuario", "administrador", "orientador", "bolsista"), false);
$opcao = getParameter("opcao");
if (!empty($opcao)) {

    /**
     * @var $link mysqli
     */

    switch ($opcao) {
        case "":
            logout();
            break;

        case Constantes::CADASTRAR_BOLSISTA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            cadastrarIntegrante("bolsista", $link);

            header('location: ../e-jbsm_cadastro_bolsista.php?info=cadastrado');
            break;

        case Constantes::CADASTRAR_ORIENTADOR:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            cadastrarIntegrante("orientador", $link);

            header('location: ../e-jbsm_cadastro_orientador.php?info=cadastrado');
            break;

        case Constantes::CADASTRAR_ADMINISTRADOR:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            cadastrarIntegrante("administrador", $link);

            header('location: ../e-jbsm_cadastro_administrador.php?info=cadastrado');
            break;

        case Constantes::CADASTRAR_VISITA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $visita_instituicao = htmlspecialchars($_POST["visita_instituicao"], ENT_QUOTES, 'UTF-8');
            $visita_tipo_instituicao = htmlspecialchars($_POST["visita_tipo_instituicao"], ENT_QUOTES, 'UTF-8');
            $visita_cidade = htmlspecialchars($_POST["visita_cidade"], ENT_QUOTES, 'UTF-8');
            $visita_visitantes = htmlspecialchars($_POST["visita_numero_visitantes"], ENT_QUOTES, 'UTF-8');
            $visita_curso = htmlspecialchars($_POST["visita_curso"], ENT_QUOTES, 'UTF-8');
            $visita_oficina = htmlspecialchars($_POST["visita_oficina"], ENT_QUOTES, 'UTF-8');
            $visita_data = htmlspecialchars($_POST["visita_data"], ENT_QUOTES, 'UTF-8');
            $visita_hora = htmlspecialchars($_POST["visita_hora"], ENT_QUOTES, 'UTF-8');
            $visita_duracao = htmlspecialchars($_POST["visita_duracao"], ENT_QUOTES, 'UTF-8');
            $visita_monitor = htmlspecialchars($_POST["visita_monitor"], ENT_QUOTES, 'UTF-8');
            $visita_auxilio_conteudo = htmlspecialchars($_POST["visita_auxilio_conteudo"], ENT_QUOTES, 'UTF-8');
            $visita_conteudo = getParameter("visita_conteudo");
            $visita_responsavel = htmlspecialchars($_POST["visita_responsavel"], ENT_QUOTES, 'UTF-8');
            $visita_fone = getParameter("visita_fone");
            if (isset($_POST["visita_plano"])) {
                $visita_plano = htmlspecialchars($_POST["visita_plano"], ENT_QUOTES, 'UTF-8');
            } else {
                $visita_plano = "";
            }

            $sql = "insert into ejbsm_visita(login, oficina, data, hora, visitantes, fone, instituicao, tipo_instituicao, cidade,
curso, conteudo, auxilio, monitor, duracao, responsavel, plano, status, excluida, ano)
            values('$user_login', '$visita_oficina', '$visita_data', '$visita_hora', '$visita_visitantes', '$visita_fone',
            '$visita_instituicao', '$visita_tipo_instituicao', '$visita_cidade', '$visita_curso',
            '$visita_conteudo', '$visita_auxilio_conteudo', '$visita_monitor', '$visita_duracao', '$visita_responsavel', '$visita_plano', 'Em espera', 'nao', '');";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_cadastro_visita.php?info=cadastrada#cadastrada');

            break;

        case Constantes::EDITAR_VISITA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $visita_login = (htmlspecialchars($_POST["visita_login"], ENT_QUOTES, 'UTF-8'));
            $visita_instituicao = (htmlspecialchars($_POST["visita_instituicao"], ENT_QUOTES, 'UTF-8'));
            $visita_tipo_instituicao = (htmlspecialchars($_POST["visita_tipo_instituicao"], ENT_QUOTES, 'UTF-8'));
            $visita_cidade = (htmlspecialchars($_POST["visita_cidade"], ENT_QUOTES, 'UTF-8'));
            $visita_visitantes = (htmlspecialchars($_POST["visita_numero_visitantes"], ENT_QUOTES, 'UTF-8'));
            $visita_curso = (htmlspecialchars($_POST["visita_curso"], ENT_QUOTES, 'UTF-8'));
            $visita_oficina = (htmlspecialchars($_POST["visita_oficina"], ENT_QUOTES, 'UTF-8'));
            $visita_data = (htmlspecialchars($_POST["visita_data"], ENT_QUOTES, 'UTF-8'));
            $visita_hora = (htmlspecialchars($_POST["visita_hora"], ENT_QUOTES, 'UTF-8'));
            $visita_duracao = (htmlspecialchars($_POST["visita_duracao"], ENT_QUOTES, 'UTF-8'));
            $visita_monitor = (htmlspecialchars($_POST["visita_monitor"], ENT_QUOTES, 'UTF-8'));
            $visita_auxilio_conteudo = (htmlspecialchars($_POST["visita_auxilio_conteudo"], ENT_QUOTES, 'UTF-8'));
            $visita_conteudo = (htmlspecialchars($_POST["visita_conteudo"], ENT_QUOTES, 'UTF-8'));
            $visita_responsavel = (htmlspecialchars($_POST["visita_responsavel"], ENT_QUOTES, 'UTF-8'));
            $visita_fone = (htmlspecialchars($_POST["visita_fone"], ENT_QUOTES, 'UTF-8'));
            $visita_plano = (htmlspecialchars($_POST["visita_plano"], ENT_QUOTES, 'UTF-8'));
            $visita_status = (htmlspecialchars($_POST["visita_status"], ENT_QUOTES, 'UTF-8'));
            $visita_id = (htmlspecialchars($_POST["visita_id"], ENT_QUOTES, 'UTF-8'));

            $sql = "update ejbsm_visita set oficina = '$visita_oficina', data = '$visita_data', hora = '$visita_hora', visitantes = '$visita_visitantes', "
                . "fone = '$visita_fone', instituicao = '$visita_instituicao', tipo_instituicao= '$visita_tipo_instituicao', "
                . "cidade = '$visita_cidade', curso = '$visita_curso', conteudo = '$visita_conteudo', auxilio = '$visita_auxilio_conteudo', "
                . "monitor = '$visita_monitor', duracao = '$visita_duracao', responsavel = '$visita_responsavel', plano = '$visita_plano', "
                . "status = '$visita_status' where id = '$visita_id';";

            $link->query($sql) or die(mysqli_error($link));

            if ($visita_status == "Confirmada") {
                $sql = "select * from ejbsm_usuario where login = '$visita_login';";

                $result = $link->query($sql);
                $linha = mysqli_fetch_assoc($result);

                $user_nome = $linha["nome"];
                $user_email = $linha["email"];

                $email_assunto = "Agendamento de visita";
                $email_data = date("d/m/y");
                $headers = "Content-Type:text/html; charset=UTF-8\n";
                $headers .= "From: JBSM<adm.jsbm@gmail.com>\n";
                $headers .= "X-Sender: <adm.jbsm@gmail.com>\n";
                $headers .= "X-Mailer: PHP v" . phpversion() . "\n";
                $headers .= "X-IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
                $headers .= "Return-Path: <adm.jbsm@gmail.com>\n";
                $headers .= "MIME-Version: 1.0\n";
                $email_mensagem = "
	Olá $user_nome, sua solicitação de acompanhamento de visita ao Jardim Botânico da UFSM foi confirmada.<br>
	<b>Instituição:</b> $visita_instituicao.<br>
	<b>Dia:</b> $visita_data.<br>
	<b>Hora:</b> $visita_hora.<br>
	<b>Visitantes:</b> $visita_visitantes.<br>
	Você pode verificar os dados desta visita em www.ufsm.br/jbsm/e-jbsm.<br>
	Qualquer dúvida entraremos em contato através de e-mail ou por telefone.<br>
	<br>
	<strong>Caso você não tenha feito este agendamento nos comunique para que possamos verificar o incidente,  obrigado.</strong><br>

	<strong> Descrição:</strong> Agendamento de visita no Jardim Botânico da Universidade Federal de Santa Maria.<br>

	<strong>Unidade:</strong> CCNE - Centro de Ciências Naturais e Exatas.<br>
	<strong>Telefone:</strong> (55)3220-8339 - ramal 222 ou 225. <br>
	<strong>Secretaria administrativa:</strong> Prédio 16 - CENTRO DE EDUCAÇÃO, sala 3131C <br>
	<br>
	<strong>Cadastro no sistema:</strong> $email_data<br>
	<br>
	<strong>Obs:</strong> Nosso horário de atendimento é das 8:00 às 12:00 e das 13:00 às 17:00.
        Você pode abrir um chamado fora deste horário, entretanto, somente vamos recebê-lo dentro do horário de atendimento. Informamos que o prazo para atendimento de sua solicitação é de 48 horas a partir da abertura da chamada, descontando sábados, domingos e feriados.<br>

	-- <br>
	<strong>Cordialmente,</strong><br>
	<br>
	<strong>Pedro Antonello</strong><br>
	<strong>Secretário Administrativo do Jardim Botânico da Universidade Federal de Santa Maria</strong><br>
	<strong>Telefones:</strong> (55) 3220-8339, ramais 222 e 225, e (55) 9193.8183<br>
	<strong>E-mail:</strong> adm.jbsm@gmail.com<br>
	<strong>Site JBSM:</strong> http://www.ufsm.br/jbsm<br>
	<strong>Agendamentos:</strong> http://www.ufsm.br/jbsm/visitas<br>
	";
                $sql = "select email from ejbsm_usuario where login = '$visita_monitor'";
                $dados = $link->query($sql);
                $guia_email = mysqli_fetch_object($dados);
                mail("jardimbotanico@mail.ufsm.br", "$email_assunto", "$email_mensagem", $headers);
                mail("jardimbotanico.ufsm@hotmail.com", "$email_assunto", "$email_mensagem", $headers);
                mail("$guia_email->email", "$email_assunto", "$email_mensagem", $headers);
                mail("$user_email", "$email_assunto", "$email_mensagem", $headers);
            }
            header('location: ../e-jbsm_lista_visitas.php?info=editada');
            break;

        case Constantes::EXCLUIR_VISITA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");

            $sql = "update ejbsm_visita set excluida = '$user_login' where id = $id;";

            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_lista_visitas.php?info=excluida');

            break;

        case Constantes::RESTAURAR_VISITA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");

            $sql = "update ejbsm_visita set excluida = 'nao' where id = $id;";
            $link->query($sql);

            header('location: ../e-jbsm_lixeira.php?info=restaurada');

            break;

        case Constantes::DELETAR_VISITA:
            $user_login = $_SESSION["user_login"];

            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");

            $sql = "delete from ejbsm_visita where id = $id;";
            $link->query($sql);

            header('location: ../e-jbsm_lixeira.php?info=deletada');

            break;

        case Constantes::CADASTRAR_FREQUENCIA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $data = getParameter("data");
            $entrada = getParameter("entrada");
            $saida = getParameter("saida");

            $sql = "insert into ejbsm_frequencia(data, entrada, saida, login) values('$data', '$entrada', '$saida', '$user_login');";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_frequencia.php');
            break;

        case Constantes::CADASTRAR_PROGRAMACAO:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $programacao_data = htmlspecialchars($_POST["programacao_data"], ENT_QUOTES, 'UTF-8');
            $programacao_status = htmlspecialchars($_POST["programacao_status"], ENT_QUOTES, 'UTF-8');
            $programacao_fato = htmlspecialchars($_POST["programacao_fato"], ENT_QUOTES, 'UTF-8');
            $programacao_pontos_produtivos = htmlspecialchars($_POST["programacao_pontos_produtivos"], ENT_QUOTES, 'UTF-8');
            $programacao_pontos_improdutivos = htmlspecialchars($_POST["programacao_pontos_improdutivos"], ENT_QUOTES, 'UTF-8');
            $programacao_sugestao = htmlspecialchars($_POST["programacao_sugestao"], ENT_QUOTES, 'UTF-8');
            $programacao_material = htmlspecialchars($_POST["programacao_material"], ENT_QUOTES, 'UTF-8');
            $programacao_prioritaria = htmlspecialchars($_POST["programacao_prioritaria"], ENT_QUOTES, 'UTF-8');
            $programacao_segunda = htmlspecialchars($_POST["programacao_segunda"], ENT_QUOTES, 'UTF-8');
            $programacao_terca = htmlspecialchars($_POST["programacao_terca"], ENT_QUOTES, 'UTF-8');
            $programacao_quarta = htmlspecialchars($_POST["programacao_quarta"], ENT_QUOTES, 'UTF-8');
            $programacao_quinta = htmlspecialchars($_POST["programacao_quinta"], ENT_QUOTES, 'UTF-8');
            $programacao_sexta = htmlspecialchars($_POST["programacao_sexta"], ENT_QUOTES, 'UTF-8');

            $sql = "insert into ejbsm_programacao(data, login, emocional, fato_significativo, produtivos, improdutivos,
material_necessario, sugestao, prioridades, segunda, terca, quarta, quinta, sexta) values
('$programacao_data', '$user_login', '$programacao_status', '$programacao_fato', '$programacao_pontos_produtivos', "
                . "'$programacao_pontos_improdutivos', '$programacao_material', '$programacao_sugestao', "
                . "'$programacao_prioritaria', '$programacao_segunda', '$programacao_terca', '$programacao_quarta', "
                . "'$programacao_quinta', '$programacao_sexta');";

            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_lista_programacao.php?info=cadastrada');

            break;

        case Constantes::EDITAR_PROGRAMACAO:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");
            $programacao_data = htmlspecialchars($_POST["programacao_data"]);
            $programacao_status = htmlspecialchars($_POST["programacao_status"]);
            $programacao_fato = htmlspecialchars($_POST["programacao_fato"]);
            $programacao_pontos_produtivos = htmlspecialchars($_POST["programacao_pontos_produtivos"]);
            $programacao_pontos_improdutivos = htmlspecialchars($_POST["programacao_pontos_improdutivos"]);
            $programacao_sugestao = htmlspecialchars($_POST["programacao_sugestao"]);
            $programacao_material = htmlspecialchars($_POST["programacao_material"]);
            $programacao_prioritaria = htmlspecialchars($_POST["programacao_prioritaria"]);
            $programacao_segunda = htmlspecialchars($_POST["programacao_segunda"]);
            $programacao_terca = htmlspecialchars($_POST["programacao_terca"]);
            $programacao_quarta = htmlspecialchars($_POST["programacao_quarta"]);
            $programacao_quinta = htmlspecialchars($_POST["programacao_quinta"]);
            $programacao_sexta = htmlspecialchars($_POST["programacao_sexta"]);

            $sql = "UPDATE ejbsm_programacao SET data = '$programacao_data',
emocional = '$programacao_status',
fato_significativo = '$programacao_fato',
produtivos = '$programacao_pontos_produtivos',
improdutivos = p$programacao_pontos_improdutivosrogramacao_pontos_improdutivos,
material_necessario = '$programacao_material',
sugestao = '$programacao_sugestao',
prioridades = '$programacao_prioritaria',
segunda = '$programacao_segunda',
terca = '$programacao_terca',
quarta = '$programacao_quarta',
quinta = '$programacao_quinta',
sexta = '$programacao_sexta' WHERE id = '$id';";

            $link->query($sql) or die(mysqli_error($link));
            header('location: ../e-jbsm_lista_programacao.php?info=editada');

            break;

        case Constantes::DELETAR_PROGRAMACAO:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");

            $sql = "delete from ejbsm_programacao WHERE id = '$id'";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_lista_programacao.php?info=excluida');

            break;

        case Constantes::CADASTRAR_PLANO:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $nome = htmlspecialchars($_POST["nome"]);
            $publicoAlvo = htmlspecialchars($_POST["publicoAlvo"]);
            $objetivo = htmlspecialchars($_POST["objetivo"]);
            $assunto = htmlspecialchars($_POST["assunto"]);
            $estrategia = htmlspecialchars($_POST["estrategia"]);
            $recursos = htmlspecialchars($_POST["recursos"]);
            $locais = htmlspecialchars($_POST["locais"]);
            $relevancia = htmlspecialchars($_POST["relevancia"]);
            $instrumento = htmlspecialchars($_POST["instrumento"]);
            $nomeGuia = htmlspecialchars($_POST["nomeGuia"]);

            $sql = "INSERT INTO ejbsm_plano "
                . "(nome, publico_alvo, monitor, objetivo, assunto, estrategia, "
                . "recursos, locais, relevancia, instrumento, login) VALUES ("
                . "'$nome', '$publicoAlvo', '$nomeGuia', '$objetivo', '$assunto', '$estrategia', '$recursos', '$locais', "
                . "'$relevancia', '$instrumento', '$user_login');";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_planos.php?info=cadastrado');

            break;

        case Constantes::EDITAR_PLANO:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");
            $nome = getParameter("nome");
            $publicoAlvo = getParameter("publicoAlvo");
            $objetivo = getParameter("objetivo");
            $assunto = getParameter("assunto");
            $estrategia = getParameter("estrategia");
            $recursos = getParameter("recursos");
            $locais = getParameter("locais");
            $relevancia = getParameter("relevancia");
            $instrumento = getParameter("instrumento");
            $nomeGuia = getParameter("nomeGuia");

            $sql = "UPDATE  ejbsm_plano SET  nome =  '$nome',
publico_alvo =  '$publicoAlvo',
monitor =  '$nomeGuia',
objetivo =  '$objetivo',
assunto =  '$assunto',
estrategia =  '$estrategia',
recursos =  '$recursos',
locais =  '$locais',
relevancia =  '$relevancia',
instrumento =  '$instrumento',
login =  '$user_login' WHERE  id ='$id';";

            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_planos.php?info=editado');

            break;

        case Constantes::DELETAR_PLANO:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");

            $sql = "delete from ejbsm_plano WHERE id = '$id'";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_planos.php?info=excluido');

            break;

        case Constantes::CADASTRAR_OFICINA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $nome = htmlspecialchars($_POST["nome"]);
            $monitor = htmlspecialchars($_POST["nome_monitor"]);
            $descricao = htmlspecialchars($_POST["descricao"]);
            $orientador = htmlspecialchars($_POST["orientador"]);
            $material = htmlspecialchars($_POST["material"]);
            $anexo = htmlspecialchars($_POST["link"]);

            $sql = "INSERT INTO  ejbsm_oficina (login, monitor, orientador, nome, descricao, material, anexo) VALUES ('$user_login', '$monitor', '$orientador',  '$nome',  '$descricao', '$material',  '$anexo');";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_oficinas.php?info=cadastrada');

            break;

        case Constantes::EDITAR_OFICINA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $nome = htmlspecialchars($_POST["nome"]);
            $nome_monitor = htmlspecialchars($_POST["nome_monitor"]);
            $descricao = htmlspecialchars($_POST["descricao"]);
            $orientador = htmlspecialchars($_POST["orientador"]);
            $material = htmlspecialchars($_POST["material"]);
            $anexo = htmlspecialchars($_POST["link"]);
            $id = getParameter("id");

            $sql = "UPDATE  ejbsm_oficina SET  nome =  '$nome', monitor =  '$nome_monitor', login =  '$user_login', descricao =  '$descricao', orientador =  '$orientador', material =  '$material', anexo =  '$anexo' WHERE  id = $id;";

            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_oficinas.php?info=editada');

            break;

        case Constantes::DELETAR_OFICINA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");

            $sql = "delete from ejbsm_oficina WHERE id = '$id'";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_oficinas.php?info=deletada');

            break;

        case Constantes::EDITAR_BOLSISTA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $nome = getParameter("nome");
            $matricula = getParameter("matricula");
            $loginBolsista = getParameter("loginBolsista");
            if (isset($_POST["senha"])) {
                $senha = sha1($_POST["senha"]);
                $sql = "update ejbsm_usuario set senha = '$senha' where login = '$loginBolsista'";
                $link->query($sql) or die(mysqli_error($link));
            }
            $area = htmlspecialchars($_POST["area"]);
            $subarea = htmlspecialchars($_POST["subarea"]);
            $projeto = htmlspecialchars($_POST["projeto"]);
            $bolsa = htmlspecialchars($_POST["bolsa"]);
            $email = htmlspecialchars($_POST["email"]);
            $fixo = htmlspecialchars($_POST["fixo"]);
            $celular = htmlspecialchars($_POST["celular"]);
            $rg = htmlspecialchars($_POST["rg"]);
            $orgao = htmlspecialchars($_POST["orgao"]);
            $cpf = htmlspecialchars($_POST["cpf"]);
            $conta = htmlspecialchars($_POST["conta"]);
            $banco = htmlspecialchars($_POST["banco"]);
            $agencia = htmlspecialchars($_POST["agencia"]);
            $tipoConta = htmlspecialchars($_POST["tipoconta"]);
            $status = htmlspecialchars($_POST["status"]);

            $sql = "update ejbsm_usuario set nome='$nome', email = '$email', fixo = '$fixo', celular = '$celular', status = '$status' where login = '$loginBolsista'";
            $link->query($sql) or die(mysqli_error($link));

            $sql = "update ejbsm_integrante set id='$matricula', area = '$area', subarea = '$subarea', projeto = '$projeto', bolsa = '$bolsa', rg = '$rg', orgao = '$orgao', cpf = '$cpf', conta = '$conta', banco = '$banco', agencia = '$agencia', tipo_conta = '$tipoConta' where login = '$loginBolsista'";
            $link->query($sql) or die(mysqli_error($link));

            ///Horarios
            $semana = array("seg", "ter", "qua", "qui", "sex");
            $h = 8;
            $h2 = 9;
            $sql = "UPDATE ejbsm_horario_bolsista SET ";
            for ($i = 0; $i < 8; $i++) {
                if ($h == 12) {
                    $h++;
                    $h2++;
                }
                for ($j = 0; $j < 5; $j++) {
                    ${$semana[$j] . $h . $h2} = 0;
                    if (isset($_POST["$semana[$j]$h$h2"])) {
                        if($j != 0 OR $i != 0)
                            $sql .= ', ';
                        $sql.= $semana[$j] .$h . $h2 . " = '" . getParameter($semana[$j] . $h . $h2) . "' ";
                    }
                }
                $h++;
                $h2++;
            }
            $sql.= " WHERE login =  '$loginBolsista'";

            $link->query($sql) or die(mysqli_error($link));
            header('location: ../e-jbsm_lista_bolsistas.php?info=editado');
            break;

        case Constantes::ENVIAR_MENSAGEM:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $topico_mensagem = htmlspecialchars($_POST["topico_mensagem"], ENT_QUOTES, 'UTF-8');
            $topico_para = htmlspecialchars($_POST["topico_para"]);
            //

            $sql = "insert into ejbsm_batepapo_mensagem(data, hora, login, para, mensagem) values(curdate(), curtime(), '$user_login', '$topico_para', '$topico_mensagem');";
            $result = $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_bate-papo.php#primeiro_topico');

            break;

        case Constantes::APAGAR_MENSAGEM:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");

            $sql = "delete from ejbsm_batepapo_mensagem where id = '$id'";
            $link->query($sql) or die(mysqli_error($link));

            $sql = "delete from ejbsm_batepapo_resposta where id_mensagem = '$id'";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_bate-papo.php#primeiro_topico');

            break;

        case Constantes::ENVIAR_RESPOSTA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");
            $topico_resposta = htmlspecialchars($_POST["topico_resposta"], ENT_QUOTES, 'UTF-8');
            //

            $sql = "insert into ejbsm_batepapo_resposta(data, hora, login, resposta, id_mensagem) values(curdate(), curtime(), '$user_login', '$topico_resposta', '$id');";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_bate-papo.php#primeiro_topico');

            break;

        case Constantes::APAGAR_RESPOSTA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = getParameter("id");

            $sql = "delete from ejbsm_batepapo_resposta where id = '$id'";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_bate-papo.php#primeiro_topico');

            break;

        case Constantes::ALTERAR_IMAGEM:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            if (isset($_FILES['arquivo'])) {
                move_uploaded_file($_FILES['arquivo']['tmp_name'], 'arquivos_imagem_perfil/' . $user_login . ".jpg");
            }

            header('location: ../e-jbsm_perfil.php');

            break;

        case Constantes::EDITAR_PERFIL:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $nome = htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8');
            $senha = sha1(htmlspecialchars($_POST["senha"], ENT_QUOTES, 'UTF-8'));
            $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
            $cidade = htmlspecialchars($_POST["cidade"], ENT_QUOTES, 'UTF-8');
            $fixo = htmlspecialchars($_POST["fixo"], ENT_QUOTES, 'UTF-8');
            $celular = htmlspecialchars($_POST["celular"], ENT_QUOTES, 'UTF-8');
            if ($user_permissao != "usuario") {
                $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
                $rg = htmlspecialchars($_POST["rg"], ENT_QUOTES, 'UTF-8');
                $orgao = htmlspecialchars($_POST["orgao"], ENT_QUOTES, 'UTF-8');
                $cpf = htmlspecialchars($_POST["cpf"], ENT_QUOTES, 'UTF-8');
                $conta = htmlspecialchars($_POST["conta"], ENT_QUOTES, 'UTF-8');
                $banco = htmlspecialchars($_POST["banco"], ENT_QUOTES, 'UTF-8');
                $agencia = htmlspecialchars($_POST["agencia"], ENT_QUOTES, 'UTF-8');
                $tipoConta = htmlspecialchars($_POST["tipoconta"], ENT_QUOTES, 'UTF-8');
            }

            $sql = "update ejbsm_usuario set senha = '$senha', nome='$nome', email = '$email', fixo = '$fixo', celular = '$celular', cidade = '$cidade' where login = '$user_login'";
            $link->query($sql) or die(mysqli_error($link));

            if ($user_permissao != "usuario") {
                $sql = "update ejbsm_integrante set id='$id', rg = '$rg', orgao = '$orgao', cpf = '$cpf', conta = '$conta', banco = '$banco', agencia = '$agencia', tipo_conta = '$tipoConta' where login = '$user_login'";
                $link->query($sql) or die(mysqli_error($link));
            }

            ///Horarios
            $semana = array("seg", "ter", "qua", "qui", "sex");
            $h = 8;
            $h2 = 9;
            $sql.= " WHERE login =  '$user_login'";


            $link->query($sql) or die(mysqli_error($link));

            $_SESSION["user_senha"] = $senha;

            header('location: ../e-jbsm_perfil.php');

            break;

        case Constantes::ALTERAR_DISPONIBILIDADE:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $manha_segunda = getParameter("manha_segunda", true);
            $manha_terca = getParameter("manha_terca", true);
            $manha_quarta = getParameter("manha_quarta", true);
            $manha_quinta = getParameter("manha_quinta", true);
            $manha_sexta = getParameter("manha_sexta", true);

            $tarde_segunda = getParameter("tarde_segunda", true);
            $tarde_terca = getParameter("tarde_terca", true);
            $tarde_quarta = getParameter("tarde_quarta", true);
            $tarde_quinta = getParameter("tarde_quinta", true);
            $tarde_sexta = getParameter("tarde_sexta", true);

            $sql = "update ejbsm_horarios_monitores set manha_segunda = '$manha_segunda', manha_terca = '$manha_terca', manha_quarta = '$manha_quarta',
manha_quinta = '$manha_quinta', manha_sexta = '$manha_sexta', tarde_segunda = '$tarde_segunda', tarde_terca = '$tarde_terca',
tarde_quarta = '$tarde_quarta', tarde_quinta = '$tarde_quinta', tarde_sexta = '$tarde_sexta';";

            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_administracao.php');
            break;

        case Constantes::ATIVAR_DESATIVAR;
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $login = getParameter("login");
            $op = getParameter("op");

            $sql = "update ejbsm_usuario set status = '$op' where login = '$login'";
            $link->query($sql) or die(mysqli_error($link));

            header("location: ../forum_info.php?info=login&login=$login");

            break;

        case Constantes::ALTERAR_LOGO;
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            if (isset($_FILES["logo"])) {
                if (file_exists('arquivos_imagem_sistema/logo.png')) {
                    unlink('arquivos_imagem_sistema/logo.png');
                }
                if (file_exists('arquivos_imagem_sistema/logo.jpeg')) {
                    unlink('arquivos_imagem_sistema/logo.jpeg');
                }
                if (file_exists('arquivos_imagem_sistema/logo.jpg')) {
                    unlink('arquivos_imagem_sistema/logo.jpeg');
                }
                $ext = $_FILES['logo']['type'];
                $ext = explode("/", $ext);;
                move_uploaded_file($_FILES['logo']['tmp_name'], 'arquivos_imagem_sistema/logo' . '.' . 'png');
            }

            header('location: ../e-jbsm_administracao.php');
            break;

        case Constantes::ALTERAR_FUNDO;
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            if (isset($_FILES["fundo"])) {
                if (file_exists('arquivos_imagem_sistema/fundo.png')) {
                    unlink('arquivos_imagem_sistema/fundo.png');
                }
                if (file_exists('arquivos_imagem_sistema/fundo.jpeg')) {
                    unlink('arquivos_imagem_sistema/fundo.jpeg');
                }
                if (file_exists('arquivos_imagem_sistema/fundo.jpg')) {
                    unlink('arquivos_imagem_sistema/fundo.jpeg');
                }
                $ext = $_FILES['fundo']['type'];
                $ext = explode("/", $ext);;
                move_uploaded_file($_FILES['fundo']['tmp_name'], 'arquivos_imagem_sistema/fundo' . '.' . 'png');
            }

            header('location: ../e-jbsm_administracao.php');
            break;

        case Constantes::ALTERAR_TITULO;
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $sistema_titulo = getParameter("titulo");

            $sql = "update ejbsm_informacao set titulo = '$sistema_titulo'";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_administracao.php');
            break;

        case Constantes::ALTERAR_INFORMACOES;
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $nome = getParameter("nome");
            $instituicao = getParameter("instituicao");
            $fone1 = getParameter("fone1");
            $fone2 = getParameter("fone2");
            $email = getParameter("email");
            $endereco = getParameter("endereco");
            $descricao = getParameter("descricao");
            $latitude = getParameter("latitude");
            $longitude = getParameter("longitude");

            $sql = "insert ignore into ejbsm_informacao(id, nome, instituicao, fone1, fone2, email, endereco, descricao, latitude, longitude) values(1, '$nome', '$instituicao', '$fone1', '$fone2', '$email', '$endereco', '$descricao', '$latitude', '$longitude')
 on duplicate key update nome = '$nome', instituicao = '$instituicao', fone1 = '$fone1', fone2 = '$fone2', email = '$email', endereco  = '$endereco', descricao = '$descricao', latitude = '$latitude', longitude = '$longitude'";
            $link->query($sql) or die(mysqli_error($link));

            header('location: ../e-jbsm_administracao.php');
            break;
    }
} else {
    logout();
}

function cadastrarIntegrante($permissao, $link)
{
    /**
     * @var $link mysqli
     */

    $login = "";
    $senha = "";
    $nome = "";
    $id = "";
    $email = "";
    $fixo = "";
    $celular = "";
    $rg = "";
    $orgao = "";
    $cpf = "";
    $area = "";
    $subarea = "";
    $projeto = "";
    $bolsa = "";
    $conta = "";
    $tipo_conta = "";
    $banco = "";
    $agencia = "";

    if (!empty(getParameter("matricula"))) {
        $id = getParameter("matricula");
    }elseif(!empty(getParameter("siape"))) {
        $id = getParameter("siape");
    }

    if (!empty(getParameter("login"))) {
        $login = getParameter("login");
    }
    if (!empty(getParameter("senha"))) {
        $senha = sha1(getParameter("senha"));
    }
    if (!empty(getParameter("nome"))) {
        $nome = getParameter("nome");
    }
    if (!empty(getParameter("email"))) {
        $email = getParameter("email");
    }
    if (!empty(getParameter("fixo"))) {
        $fixo = getParameter("fixo");
    }
    if (!empty(getParameter("celular"))) {
        $celular = getParameter("celular");
    }
    if (!empty(getParameter("rg"))) {
        $rg = getParameter("rg");
    }
    if (!empty(getParameter("orgao"))) {
        $orgao = getParameter("orgao");
    }
    if (!empty(getParameter("cpf"))) {
        $cpf = getParameter("cpf");
    }
    if (!empty(getParameter("area"))) {
        $area = getParameter("area");
    }
    if (!empty(getParameter("subarea"))) {
        $subarea = getParameter("subarea");
    }
    if (!empty(getParameter("projeto"))) {
        $projeto = getParameter("projeto");
    }
    if (!empty(getParameter("bolsa"))) {
        $bolsa = getParameter("bolsa");
    }
    if (!empty(getParameter("conta"))) {
        $conta = getParameter("conta");
    }
    if (!empty(getParameter("tipo_conta"))) {
        $tipo_conta = getParameter("tipo_conta");
    }
    if (!empty(getParameter("banco"))) {
        $banco = getParameter("banco");
    }
    if (!empty(getParameter("agencia"))) {
        $agencia = getParameter("agencia");
    }

    $sql = "INSERT INTO ejbsm_usuario(login, senha, nome, email, fixo, celular, status, permissao, cidade, tentativas_login) VALUES ('$login', '$senha', '$nome', '$email', '$fixo', '$celular', 'Ativo', '$permissao', '', 0);";
    $link->query($sql) or die(mysqli_error($link));

    $sql = "INSERT INTO ejbsm_integrante(login, id, cpf, rg, orgao, area, subarea, projeto, banco, conta, tipo_conta, agencia, bolsa) VALUES ('$login', '$id', '$cpf', '$rg', '$orgao', '$area', '$subarea', '$projeto', '$banco', '$conta', '$tipo_conta', '$agencia', '$bolsa');";
    $link->query($sql) or die(mysqli_error($link));
}