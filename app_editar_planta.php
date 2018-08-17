<?php
$permissao = array("administrador", "orientador", "bolsista");
include 'functions/permitir_app.php';

$info = "";
if (isset($_GET["info"]))
    $info = $_GET["info"];

?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Editar planta</h3>

        <div class="row">
            <div class="col-md-3">
                <? include "app_menu.php"; ?>
            </div>
            <div class="col-md-9">
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
                <h3>Pesuisar para editar</h3>
                <script>
                    function showHint(str) {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function () {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                            }
                        }
                        xmlhttp.open("GET", "functions/ajax_editar_plantas.php?q=" + str, true);
                        xmlhttp.send();
                    }
                </script>
                <p><b>Digite o nome ou alguma característica da planta para obter resultados:</b></p>
                <input class="form-control" type="text" onkeyup="showHint(this.value)">
                <hr>
            </div>
            <div class="col-md-9">
                <?
                if (isset($_GET["id"])) {
                    $id_planta = $_GET["id"];
                    $sql = "select * from ejbsm_planta WHERE id = $id_planta";
                    $result = $link->query($sql);
                    $planta = mysqli_fetch_object($result);
                    ?>
                    Visualizações: <?=$planta->visualizada?><br>
                    Ultima visualização: <?=$planta->ult_visualizada?><hr>
                    <form action="controller/app_controll.php" method="post" enctype="multipart/form-data">
                        <div class="col-md-4">
                            Nome popular
                            <input class="form-control" type="text" value="<?= $planta->nome_popular ?>"
                                   name="popular" placeholder="popular" required="">
                            Gênero
                            <input class="form-control" type="text" value="<?= $planta->genero ?>" name="gênero"
                                   placeholder="gênero" required="">
                            Espécie
                            <input class="form-control" type="text" value="<?= $planta->especie ?>" name="espécie"
                                   placeholder="espécie"
                                   required="">
                            Família
                            <input class="form-control" type="text" value="<?= $planta->familia ?>" name="família"
                                   placeholder="família"
                                   required="">
                        </div>
                        <div class="col-md-4">
                            Origem
                            <input class="form-control" type="text" value="<?= $planta->origem ?>" name="origem"
                                   placeholder="origem" required="">
                            Exótica
                            <select name="exotica" class="form-control">
                                <option value="sim">SIM</option>
                                <option value="não">NÃO</option>
                            </select>
                            Descrição
                            <input class="form-control" type="text" value="<?= $planta->descricao ?>"
                                   name="descricao" placeholder="descricao"
                                   required="">
                            Latitude
                            <input class="form-control" type="text" value="<?= $planta->latitude ?>"
                                   name="latitude" placeholder="latitude"
                                   required="">
                            Longitude
                            <input class="form-control" type="text" value="<?= $planta->longitude ?>"
                                   name="longitude" placeholder="longitude"
                                   required="">
                        </div>
                        <div class="col-md-4">
                            Editar imagem <input type="checkbox" name="edit_img" value="1"><br>
                            <?
                            if ($planta->img != null) {
                                list($largura, $altura) = getimagesize("data:image/jpeg;base64," . base64_encode($planta->img));
                                $max = 240;
                                $x = ($altura * $max) / $largura;
                                echo "<img src='data:image/jpeg;base64," . base64_encode($planta->img) . "' width='$max' height='$x'>";
                            }
                            ?>
                            <script>
                                function previewFile() {
                                    var preview = document.getElementById("imagem_preview");
                                    var file = document.getElementById("preview_file").files[0]; //sames as here
                                    var reader = new FileReader();

                                    if (file.size > 2000000) {
                                        alert("Imagem selecionada ultrapassa os 2 mb de tamnho. Selecione outra.");
                                    } else {
                                        reader.onloadend = function () {
                                            preview.src = reader.result;
                                        }
                                        if (file) {
                                            reader.readAsDataURL(file);
                                        } else {
                                            preview.src = "";
                                        }
                                    }
                                }
                                previewFile();
                            </script>
                            <br>
                            Nova imagem (máximo 2mb)
                            <img id="imagem_preview" src="" height="120">
                            <input id="preview_file" class="form-control" type="file" onchange="previewFile()"
                                   name="file">
                            <br>
                            <input type="hidden" name="id" value="<?= $planta->id ?>">
                            <button class="btn btn-warning" name="opcao" value="Cadastrar planta"
                                    style="margin-bottom: 10px">
                                <span class="glyphicon glyphicon-edit"></span>
                                Salvar edição
                            </button>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-offset-8">
                            <form action="controller/app_controll.php" method="post">
                                <button type="button" class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#myModal" style="margin-left: 10px;">
                                    <span class="glyphicon glyphicon-remove"></span>
                                    Deletar planta
                                </button>
                                <div class="modal fade" id="myModal" tabindex="-1"
                                     role="dialog"
                                     aria-labelledby="myModalLabel"
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
                                                    Confirmar exclusão.</h4>
                                            </div>
                                            <div class="modal-body">
                                                <h3>Deseja mesmo excluir esta planta?
                                                    (ID: <?= $planta->id ?>)</h3>
                                                <h5>Ao excluir a planta, ela será deletada permanentemente e removidas
                                                    das
                                                    trilhas as quais foi incluída.</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Cancelar
                                                </button>
                                                <input type="hidden" value="<?= $planta->id ?>"
                                                       name="id">
                                                <button type="submit" value="Deletar planta"
                                                        class="btn btn-danger" name="opcao">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                    Deletar planta
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                <?
                }
                ?>
                <span id="txtHint">
                <?
                $sql = "select * from ejbsm_planta ORDER BY id limit 10";
                $result = $link->query($sql);
                while ($a = mysqli_fetch_object($result)) {
                    ?>
                    <a href='app_editar_planta.php?id=<?= $a->id ?>'>
                        <div class="media alert alert-info">
                            <div class="media-left">
                                <?
                                if ($a->img != null) {
                                    list($largura, $altura) = getimagesize("data:image/jpeg;base64," . base64_encode($a->img));
                                    $max = 80;
                                    $x = ($altura * $max) / $largura;
                                    echo "<img src='data:image/jpeg;base64," . base64_encode($a->img) . "' width='$max' height='$x'>";
                                } else {
                                    echo "<img src='arquivos_imagem_sistema/planta_default.png' width='80px' height='80'>";
                                }
                                ?>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?= $a->nome_popular ?></h4>
                                Espécie: <?= $a->especie ?><br>
                                Descrição: <?= $a->descricao ?>
                            </div>
                        </div>
                    </a>
                <?
                }
                ?>
                    </span>
            </div>
        </div>
    </div>
</div>