<?php

include 'e-jbsm_cabecalho.php';

$info = "";
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Pesuisa por planta</h3>

        <div class="col-md-3">
            <?php include "app_menu.php"; ?>
        </div>
        <div class="col-md-9">
            <!--BOAS VINDAS-->
            <?php if ($info == "permissao") { ?>
                <div class="alert alert-warning">
                    Somente administradores tem acesso a alterações no sistema.
                </div>
            <?php } ?>
            <div class="alert alert-info">
                Olá, aqui você pode realizar pesquisas por espécimes do JBSM.
            </div>
            <script>
                function showHint(str) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET", "helpers/ajax_pesquisar_plantas.php?q=" + str, true);
                    xmlhttp.send();
                }
            </script>
            <p><b>Digite o nome ou alguma característica da planta para obter resultados:</b></p>
            <input class="form-control" type="text" onkeyup="showHint(this.value)"
                   placeholder="Nome popular, nome científico ou descrição...">
            <hr>
            <span id="txtHint"></span>
            <!--RECEPÇÂO DE ID-->
            <?php
            if (isset($_GET["id"]) and $_GET["id"] != "") {
                $id = htmlspecialchars($_GET["id"]);
                $sql = "select * from ejbsm_planta where id = $id";
                $result = $link->query($sql);
                $planta = (mysqli_fetch_object($result));
                if (isset($planta->especie)) {
                    echo "<h3>Sobre $planta->especie</h3>";
                    ?>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <td><label>Imagem</label></td>
                                <td><label>Nome popular</label></td>
                                <td><label>Descrição</label></td>
                                <td><label>Espécie</label></td>
                                <td><label>Gênero</label></td>
                                <td><label>Família</label></td>
                                <td><label>Origem</label></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    imagemPlanta($planta->img)
                                    ?>
                                </td>
                                <td id="popular"><?php echo $planta->nome_popular ?></td>
                                <td rowspan="2" id="descricao"><?php echo $planta->descricao ?></td>
                                <td id="especie"><?php echo $planta->especie ?></td>
                                <td id="genero"><?php echo $planta->genero ?></td>
                                <td id="familia"><?php echo $planta->familia ?></td>
                                <td id="origem"><?php echo $planta->origem ?></td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                <?php
                if (!$planta->latitude == "" or !$planta->longitude == ""){
                ?>
                    <h4>Localização</h4>
                    <div id="map-canvas" style="height: 350px; width: 100%"></div>

                    Latitude:
                    <div id="planta_latitude"><?php echo $planta->latitude ?></div>
                    Longitude:
                    <div id="planta_longitude"><?php echo $planta->longitude ?></div>
                    <script src="resources/js/jquery.min.js"></script>

                    <!-- Maps API Javascript -->
                    <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
                    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>

                    <!-- Arquivo de inicialização do mapa -->
                    <script src="resources/js/mapa_planta.js"></script>
                <?php
                }
                    $sql = "update ejbsm_planta set visualizada = (ejbsm_planta.visualizada+1), ult_visualizada = now()";
                    $link->query($sql) or die(mysqli_error($link));
                } else {
                    echo "<h3>Nenhum resultado para ID $id</h3>";
                }
            }
            ?>
        </div>
    </div>
</div>