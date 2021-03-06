<?php
isUserInRole(array("usuario", "administrador", "orientador", "bolsista"), false);
$opcao = getParameter("opcao");
if (!empty($opcao)) {

    /**
     * @var $link mysqli
     */

    switch ($opcao) {
        case "":
            header('location: app.php');
            break;

        case Constantes::PESQUISAR_PLANTA:

            $sql = "select * from ejbsm_planta where id > 0";

            if (isset($_POST["nome_popular"])) {
                $nome_popular = htmlspecialchars($_POST["nome_popular"]);
                $sql .= " and nome_popular like '%$nome_popular%'";
            }
            if (isset($_POST["nome_cientifico"])) {
                $nome_cientifico = htmlspecialchars($_POST["nome_cientifico"]);
                $sql .= " and nome_cientifico like '%$nome_cientifico%'";
            }
            if (isset($_POST["descricao"])) {
                $descricao = htmlspecialchars($_POST["descricao"]);
                $sql .= " and descricao like '%$descricao%'";
            }

            header("location: ../app.php?pesquisa=$sql");

            break;

        case Constantes::CADASTRAR_PLANTA:
            $popular = getParameter("popular");
            $genero = getParameter("gênero");
            $especie = getParameter("espécie");
            $familia = getParameter("família");
            $origem = getParameter("origem");
            $exotica = getParameter("exotica");
            $latitude = getParameter("latitude");
            $longitude = getParameter("longitude");
            $descricao = getParameter("descricao");

            $img = "";

            if (isset($_FILES["file"]) and !empty($_FILES["file"]) and $_FILES["file"]["size"] <= 2000000 and !empty($_FILES['file']['tmp_name'])) {
                $img = addslashes(file_get_contents($_FILES['file']['tmp_name']));
            }

            if (isset($_POST["id"])) {
                $id = getParameter("id");
                $sql = "update ejbsm_planta set nome_popular = '$popular', descricao = '$descricao', latitude='$latitude', longitude='$longitude', especie='$especie', genero='$genero', familia='$familia', origem='$origem', exotica='$exotica'";
                if(isset($_POST["edit_img"]) and $_POST["edit_img"]==1){
                    $sql.=", img = '$img'";
                }
                $sql .="WHERE id = $id";
                $link->query($sql) or die(mysqli_error($link));

                header("location: ../app_editar_planta.php?info=editada&id=$id");
            } else {
                $sql = "insert into ejbsm_planta(nome_popular, descricao, latitude, longitude, especie, genero, familia, origem, exotica, img, florescimento_inicio, florescimento_fim) VALUES
('$popular', '$descricao', '$latitude', '$longitude', '$especie', '$genero', '$familia', '$origem', '$exotica', '$img', null, null)";

                $link->query($sql) or die(mysqli_error($link));

                header("location: ../app_cadastro_planta.php?info=cadastrada");
            }
            break;

        case Constantes::CADASTRAR_TRILHA:

            $nome_trilha = "";
            $descricao_trilha = "";
            if (isset($_POST["nome"]))
                $nome_trilha = getParameter("nome");
            if (isset($_POST["descricao"]))
                $descricao_trilha = getParameter("descricao");

            if (isset($_POST["id"])) {
                $id = getParameter("id");
                $sql = "update ejbsm_trilha set nome = '$nome_trilha', descricao = '$descricao_trilha' WHERE id = '$id'";
                $link->query($sql);

                header("location: ../app_cadastro_trilha.php?info=editada&trilha_id=$id");

                break;
            }
            $sql = "INSERT INTO ejbsm_trilha(nome, descricao) VALUES('$nome_trilha', '$descricao_trilha')";
            $link->query($sql) or die(mysqli_error($link));

            header("location: ../app_cadastro_trilha.php?info=cadastrada");

            break;

        case Constantes::DELETAR_PLANTA:
            $id_planta = getParameter("id");

            $sql = "delete from ejbsm_planta where id = $id_planta";
            $link->query($sql) or die(mysqli_error($link));

            $sql = "delete from ejbsm_associa_planta where id_planta = $id_planta";
            $link->query($sql) or die(mysqli_error($link));

            header("location: ../app_editar_planta.php?info=deletada");
            break;

        case Constantes::DELETAR_TRILHA:
            $id = getParameter("id");

            $sql = "delete from ejbsm_associa_planta where id_trilha = $id";
            $link->query($sql) or die(mysqli_error($link));

            $sql = "delete from ejbsm_trilha where id = $id";
            $link->query($sql) or die(mysqli_error($link));

            header("location: ../app_cadastro_trilha.php?info=deletada");
            break;
    }
} else {
    header('location: ../app.php');
}