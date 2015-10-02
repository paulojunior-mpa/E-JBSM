<?php

include '../Service/Conexao.php';

if (isset($_POST["opcao"])) {
    $opcao = $_POST["opcao"];
    switch ($opcao) {

        case "cadastrar":

            $nome = htmlspecialchars($_POST["nome"]);
            $curso = htmlspecialchars($_POST["curso"]);
            $cidade = htmlspecialchars($_POST["cidade"]);
            $email = htmlspecialchars($_POST["email"]);
            $fone = htmlspecialchars($_POST["fone"]);
            $data = htmlspecialchars($_POST["data"]);
            $hora = htmlspecialchars($_POST["hora"]);
            $anexo = htmlspecialchars($_POST["anexo"]);

            $sql = "insert into ejbsm_cadastro(nome, email, fone, curso, cidade, anexo, data, hora) VALUES ('$nome', '$email', '$fone',
'$curso', '$cidade', '$anexo', '$data', '$hora')";

            $link->query($sql);

            header('location: ../e-jbsm_cadastro.php?info=cadastrado');
            break;

        case "deletar":

            $id = $_POST["id"];

            $sql = "delete from ejbsm_cadastro WHERE id = $id";
            $link->query($sql);

            header('location: ../e-jbsm_lista_cadastro.php?info=deletado');

            break;

    }
} else {
    header('location: ../app.php');
}