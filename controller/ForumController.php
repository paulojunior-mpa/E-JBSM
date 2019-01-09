<?
isUserInRole(array("usuario", "administrador", "orientador", "bolsista"), false);

if (isset($_POST["opcao"]) and $_POST["opcao"] != null) {
    $opcao = htmlspecialchars($_POST["opcao"]);
    switch ($opcao) {

        case "":
            logout();
            break;

        case Constantes::CADASTRAR_AREA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_POST["user_permissao"];

            $area_nome = htmlspecialchars($_POST["nome"]);
            $area_descricao = htmlspecialchars($_POST["descricao"]);

            $sql = "select nome from ejbsm_forum_area where nome = '$area_nome'";
            $row = mysqli_fetch_object($link->query($sql) or die(mysqli_error($link)));

            if ($row->nome) {
                header('location: ../forum_cadastro_topico.php?info=area_ja_cadastrada#area');
            } else {
                $sql = "insert into ejbsm_forum_area(nome, descricao, status, login) values("
                    . "'$area_nome', '$area_descricao', 'ativa', '$user_login');";
                $link->query($sql) or die(mysqli_error($link));
                header('location: ../forum_cadastro_topico.php?info=area_cadastrada#area');
            }
            break;

        case Constantes::CADASTRAR_SUBAREA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_POST["user_permissao"];

            $subarea_nome = htmlspecialchars($_POST["nome"]);
            $id_area = htmlspecialchars($_POST["id_area"]);
            $subarea_descricao = htmlspecialchars($_POST["descricao"]);

            $sql = "select * from ejbsm_forum_subarea where nome = '$subarea_nome' AND id_area = $id_area";
            $row = mysqli_fetch_object($link->query($sql));
            if ($row->nome) {
                header('location: ../forum_cadastro_topico.php?info=subarea_ja_cadastrada#area');
            } else {
                $sql = "insert into ejbsm_forum_subarea(id_area, nome, descricao, status, login) values("
                    . "'$id_area', '$subarea_nome', '$subarea_descricao', 'ativa', '$user_login');";
                $link->query($sql) or die(mysqli_error($link));
                header('location: ../forum_cadastro_topico.php?info=subarea_cadastrada#subarea');
            }
            break;

        case Constantes::SUGERIR_AREA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $area_nome = htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8');
            $area_descricao = htmlspecialchars($_POST["descricao"], ENT_QUOTES, 'UTF-8');

            $sql = "insert into ejbsm_forum_area(nome, descricao) values("
                . "'$area_nome', '$area_descricao');";
            $link->query($sql) or die(mysqli_error($link));
            header('location: ../forum_sugestao.php?info=area_sugerida');
            break;

        case Constantes::SUGERIR_SUBAREA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $subarea_nome = htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8');
            $area_id = htmlspecialchars($_POST["area"], ENT_QUOTES, 'UTF-8');
            $subarea_descricao = htmlspecialchars($_POST["descricao"], ENT_QUOTES, 'UTF-8');

            $sql = "insert into ejbsm_forum_subarea(id_area, nome, descricao) values("
                . "'$area_id', '$subarea_nome', '$subarea_descricao');";
            $link->query($sql) or die(mysqli_error($link));
            header('location: ../forum_sugestao.php?info=subarea_sugerida');
            break;

        case Constantes::EDITAR_AREA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_POST["user_permissao"];

            $id = $_POST["id"];
            $area_nome = htmlspecialchars($_POST["area_nome"], ENT_QUOTES, 'UTF-8');
            $area_descricao = htmlspecialchars($_POST["area_descricao"], ENT_QUOTES, 'UTF-8');

            $sql = "update ejbsm_forum_area set login = '$user_login', nome = '$area_nome', descricao = '$area_descricao', status = 'ativa' where id = '$id';";
            $link->query($sql) or die(mysqli_error($link));
            header('location: ../forum_info_area.php?info=alterada');
            break;

        case Constantes::EDITAR_SUBAREA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = $_POST["id"];
            $subarea_nome = htmlspecialchars($_POST["subarea_nome"], ENT_QUOTES, 'UTF-8');
            $subarea_descricao = htmlspecialchars($_POST["subarea_descricao"], ENT_QUOTES, 'UTF-8');
            $subarea_area = htmlspecialchars($_POST["subarea_area"], ENT_QUOTES, 'UTF-8');

            $sql = "update ejbsm_forum_subarea set login = '$user_login', nome = '$subarea_nome', descricao = '$subarea_descricao', id_area = '$subarea_area', status = 'ativa' where id = '$id';";
            $link->query($sql) or die(mysqli_error($link));
            header('location: ../forum_info_subarea.php?info=alterada');
            break;

        case Constantes::DELETAR_AREA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = $_POST["id"];

            if ($id != 1) {

                $sql = "update ejbsm_forum_topico set id_area = '1' where id_area = '$id'";
                $link->query($sql);

                $sql = "update ejbsm_forum_subarea set id_area = '1' where id_area = '$id'";
                $link->query($sql);

                $sql = "delete from ejbsm_forum_area where id = '$id'";
                $link->query($sql);
            }

            header('location: ../forum_info_area.php?info=area_deletada');
            break;

        case Constantes::DELETAR_SUBAREA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = $_POST["id"];

            if ($id != 1) {
                $sql = "update ejbsm_forum_topico set id_subarea = '1' where id_subarea = '$id'";
                $link->query($sql);

                $sql = "delete from ejbsm_forum_subarea where id = '$id'";
                $link->query($sql);
            }
            header("location: ../forum_info_subarea.php?info=deletada");

            break;

        case Constantes::CADASTRAR_TOPICO:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $sql = "select max(id) as maxid from ejbsm_forum_topico";
            $r = mysqli_fetch_object($link->query($sql));
            $maxid = $r->maxid + 1;

            $nome_anexo = "Sem anexo";
            if (isset($_FILES['anexo'])) {
                $ext = $_FILES['anexo']['name'];
                $ext = end(explode(".", $ext));
                $nome_anexo = $user_login . 'T' . $maxid . '.' . $ext;
                move_uploaded_file($_FILES['anexo']['tmp_name'], 'arquivos_forum_anexo/' . $nome_anexo);
            }
            if (!file_exists("arquivos_forum_anexo/$nome_anexo")) {
                $nome_anexo = "Sem anexo";
            }

            $topico_area_subarea = explode(" / ", $_POST["area_subarea"]);
            $topico_area = $topico_area_subarea[0];
            $topico_subarea = $topico_area_subarea[1];
            $topico_assunto = htmlspecialchars($_POST["assunto"], ENT_QUOTES, 'UTF-8');
            $topico_mensagem = htmlspecialchars($_POST['mensagem'], ENT_QUOTES, 'UTF-8');

            $sql = "insert into ejbsm_forum_topico(id, assunto, id_area, id_subarea, data, hora, login, mensagem, anexo, visualizado) values("
                . "'$maxid', '$topico_assunto', '$topico_area', '$topico_subarea', curdate(), curtime(), "
                . "'$user_login', '$topico_mensagem', '$nome_anexo', '');";

            $result = $link->query($sql) or die(mysqli_error($link));

            header("location: ../forum_topico.php?topico=$maxid");

            break;

        case Constantes::CADASTRAR_RESPOSTA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $topico_id = $_POST["id"];
            $topico_resposta = htmlspecialchars($_POST["topico_resposta"], ENT_QUOTES, 'UTF-8');
            //
            $sql = "select max(id) as maxid from ejbsm_forum_resposta";
            $r = mysqli_fetch_object($link->query($sql));
            $maxid = $r->maxid + 1;

            $nome_anexo = "Sem anexo";
            if (isset($_FILES["anexo"])) {
                $ext = $_FILES['anexo']['name'];
                $ext = end(explode(".", $ext));
                $nome_anexo = $user_login . 'T' . $topico_id . 'R' . $maxid . '.' . $ext;
                move_uploaded_file($_FILES['anexo']['tmp_name'], 'arquivos_forum_anexo/' . $nome_anexo);
            }
            if (!file_exists("arquivos_forum_anexo/$nome_anexo")) {
                $nome_anexo = "Sem anexo";
            }

            $sql = "insert into ejbsm_forum_resposta(id, data, hora, login, resposta, id_topico, anexo) values("
                . "'$maxid', curdate(), curtime(), '$user_login', '$topico_resposta', '$topico_id', '$nome_anexo');";
            $result = $link->query($sql) or die(mysqli_error($link));

            header("location: ../forum_topico.php?topico=$topico_id");
            exit;

            break;

        case Constantes::DELETAR_TOPICO:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $id = $_POST["id"];
            $topico_anexo = $_POST["topico_anexo"];

            $sql = "select * from ejbsm_forum_resposta where id_topico = '$id'";
            $result = $link->query($sql) or die(mysqli_error($link));
            while ($r = mysqli_fetch_object($result)) {
                if (file_exists("arquivos_forum_anexo/$r->anexo"))
                    unlink("arquivos_forum_anexo/$r->anexo");
                $sql = "delete from ejbsm_forum_resposta where id = '$r->id'";
                $link->query($sql) or die(mysqli_error($link));
            }

            $sql = "delete from ejbsm_forum_topico where id = '$id'";
            $link->query($sql) or die(mysqli_error($link));

            if (file_exists('arquivos_forum_anexo/' . $topico_anexo)) {
                unlink("arquivos_forum_anexo/$topico_anexo");
            }

            header("location: ../forum_index.php?info=topico_deletado");

            break;

        case Constantes::DELETAR_RESPOSTA:
            $user_login = $_SESSION["user_login"];
            $user_permissao = $_SESSION["user_permissao"];

            $resposta_id = $_POST["id"];
            $resposta_anexo = $_POST["resposta_anexo"];
            $topico_id = $_POST["topico_id"];

            $sql = "delete from ejbsm_forum_resposta where id = '$resposta_id'";
            $link->query($sql) or die(mysqli_error($link));

            if (file_exists('arquivos_forum_anexo/' . $resposta_anexo)) {
                unlink("arquivos_forum_anexo/$resposta_anexo");
            }

            header("location: ../forum_topico.php?topico=$topico_id&info=resposta_deletada#respostas");

            break;
    }
}
?>