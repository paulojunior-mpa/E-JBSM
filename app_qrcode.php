<?php
isUserInRole(array("administrador", "orientador", "bolsista"));
include 'helpers/permitir_app.php';

include "helpers/phpqrcode/qrlib.php";

$info = "";
if (isset($_POST["info"]))
    $info = $_POST["info"];
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Gerador de QR Code</h3>

        <div class="row">
            <div class="col-md-3">
                <? include "app_menu.php"; ?>
            </div>
            <? if ($info == "editada") {
                echo '<div class="alert alert-success">
<span class="glyphicon glyphicon-saved"></span>
            Planta editada!
        </div>';
            } elseif ($info == "deletada") {
                echo '<div class="alert alert-danger">
<span class="glyphicon glyphicon-remove-sign"></span>
            Planta deletada!
        </div>';
            }
            ?>
            <div class="col-md-4">
                <h4>Insira uma informação</h4>

                <form action="app_qrcode.php" method="get">
                    <input class="form-control" type="text" name="id">
                    <input class="form-control" type="hidden" name="p" value="">
                    <br>
                    <button type="submit" class="btn btn-success">
                        <span class="glyphicon glyphicon-arrow-right"></span>
                        Gerar
                    </button>
                </form>
                Imagem:
                <?
                if (isset($_GET["id"]) and isset($_GET["p"])) {
                    $info = $_GET["p"] . $_GET["id"];
                    QRcode::png($info, 'arquivos_imagem_sistema/QR_atual.png', 'L', 20, 2);
                    echo "<img src='arquivos_imagem_sistema/QR_atual.png' width='200'>";
                    ?>
                    <a href="arquivos_imagem_sistema/QR_atual.png" target="_blank">
                        <button class="btn btn-primary">
                            <span class="glyphicon glyphicon-save-file"></span>
                            Salvar arquivo
                        </button>
                    </a>
                <?
                }
                echo "<h5>Resultado: <a href='$info' target='_blank'>$info</a></h5>";
                ?>
            </div>
            <div class="col-md-5">
                <h4>Ou selecione uma planta</h4>
                <script>
                    function QR_planta(str) {
                        var prefix = document.getElementById("prefix");
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function () {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                document.getElementById("QR_planta").innerHTML = xmlhttp.responseText;
                            }
                        }
                        xmlhttp.open("GET", "helpers/ajax_gerar_qrcode.php?q=" + str + "&p=" + prefix.value, true);
                        xmlhttp.send();
                    }
                </script>
                Prefixo
                <input type="text" class="form-control" id="prefix" value="http://w3.ufsm.br/jbsm/e-jbsm/app.php?id=">
                Planta
                <input class="form-control" type="text" onkeyup="QR_planta(this.value)"
                       placeholder="Nome popular, nome científico ou descrição...">
                <hr>
                <span id="QR_planta"></span>
            </div>
        </div>
    </div>
</div>