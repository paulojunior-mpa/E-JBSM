<?php
$permissao = array("usuario", "administrador", "orientador", "bolsista");

include 'Controller_func.php';
include '../Func/permitir_app.php';

if (isset($_POST["opcao"])) {
    $opcao = $_POST["opcao"];
    switch ($opcao) {
        case "":
            header('location: app.php');
            break;

        case "Pesquisar por planta":

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

        case "Cadastrar planta":
            $popular = $_POST["popular"];
            $genero = $_POST["gênero"];
            $especie = $_POST["espécie"];
            $familia = $_POST["família"];
            $origem = $_POST["origem"];
            $exotica = $_POST["exotica"];
            $latitude = $_POST["latitude"];
            $longitude = $_POST["longitude"];
            $descricao = $_POST["descricao"];

            $img = "";

            if (isset($_FILES["file"])) {
                if ($_FILES["file"]) {
                    if ($_FILES["file"]["size"] <= 2000000) {
                        $img = addslashes(file_get_contents($_FILES['file']['tmp_name']));
                    } else {

                    }
                }
            }

            if (isset($_POST["id"])) {
                $id = $_POST["id"];
                $sql = "update ejbsm_planta set nome_popular = '$popular', descricao = '$descricao', latitude='$latitude', longitude='$longitude', especie='$especie', genero='$genero', familia='$familia', origem='$origem', exotica='$exotica'";
                if(isset($_POST["edit_img"]) and $_POST["edit_img"]==1){
                    $sql.=", img = '$img'";
                }
                $sql .="WHERE id = $id";
                $link->query($sql) or die(mysqli_error($link));

                header("location: ../app_editar_planta.php?info=editada&id=$id");
            } else {
                $sql = "insert into ejbsm_planta(nome_popular, descricao, latitude, longitude, especie, genero, familia, origem, exotica, img) VALUES
('$popular', '$descricao', '$latitude', '$longitude', '$especie', '$genero', '$familia', '$origem', '$exotica', '$img')";

                $link->query($sql) or die(mysqli_error($link));

                header("location: ../app_cadastro_planta.php?info=cadastrada");
            }
            break;

        case "Cadastrar trilha":

            $nome_trilha = "";
            $descricao_trilha = "";
            if (isset($_POST["nome"]))
                $nome_trilha = $_POST["nome"];
            if (isset($_POST["descricao"]))
                $descricao_trilha = $_POST["descricao"];

            if (isset($_POST["id"])) {
                $id = $_POST["id"];
                $sql = "update ejbsm_trilha set nome = '$nome_trilha', descricao = '$descricao_trilha' WHERE id = '$id'";
                $link->query($sql);

                header("location: ../app_cadastro_trilha.php?info=editada&trilha_id=$id");

                break;
            }
            $sql = "INSERT INTO ejbsm_trilha(nome, descricao) VALUES('$nome_trilha', '$descricao_trilha')";
            $link->query($sql) or die(mysqli_error($link));

            header("location: ../app_cadastro_trilha.php?info=cadastrada");

            break;

        case "Deletar planta":
            $id_planta = $_POST["id"];

            $sql = "delete from ejbsm_planta where id = $id_planta";
            $link->query($sql) or die(mysqli_error($link));

            $sql = "delete from ejbsm_associa_planta where id_planta = $id_planta";
            $link->query($sql) or die(mysqli_error($link));

            header("location: ../app_editar_planta.php?info=deletada");
            break;

        case "Deletar trilha":
            $id = $_POST["id"];

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