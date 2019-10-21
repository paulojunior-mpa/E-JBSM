<?php
isUserInRole(array("administrador", "orientador", "bolsista"), false);
include 'e-jbsm_cabecalho.php';
$info = "";
if (isset($_GET["info"]))
    $info = $_GET["info"];

?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Editar planta</h3>

        <div class="row">
            <div class="col-md-3">
                <?php include "app_menu.php"; ?>
            </div>
            <div class="col-md-9">
                <?php if ($info == "editada") {
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
                        xmlhttp.open("GET", "helpers/ajax_editar_plantas.php?q=" + str, true);
                        xmlhttp.send();
                    }
                </script>
                <p><b>Digite o nome ou alguma característica da planta para obter resultados:</b></p>
                <input class="form-control" type="text" onkeyup="showHint(this.value)">
                <hr>
            </div>
            <div class="col-md-9">
                <?php
                if (isset($_GET["id"])) {
                    $id_planta = $_GET["id"];
                    $sql = "select * from ejbsm_planta WHERE id = $id_planta";
                    $result = $link->query($sql);
                    $planta = mysqli_fetch_object($result);
                    ?>
                    Visualizações: <?php echo $planta->visualizada?><br>
                    Ultima visualização: <?php echo $planta->ult_visualizada?><hr>
                    <form action="controller/AppControll.php" method="post" enctype="multipart/form-data">
                        <div class="col-md-4">
                            Nome popular
                            <input class="form-control" type="text" value="<?php echo $planta->nome_popular ?>"
                                   name="popular" placeholder="popular" required="">
                            Gênero
                            <input class="form-control" type="text" value="<?php echo $planta->genero ?>" name="gênero"
                                   placeholder="gênero" required="">
                            Espécie
                            <input class="form-control" type="text" value="<?php echo $planta->especie ?>" name="espécie"
                                   placeholder="espécie"
                                   required="">
                            Família
                            <input class="form-control" type="text" value="<?php echo $planta->familia ?>" name="família"
                                   placeholder="família"
                                   required="">
                        </div>
                        <div class="col-md-4">
                            Origem
                            <input class="form-control" type="text" value="<?php echo $planta->origem ?>" name="origem"
                                   placeholder="origem" required="">
                            Exótica
                            <select name="exotica" class="form-control">
                                <option value="sim">SIM</option>
                                <option value="não">NÃO</option>
                            </select>
                            Descrição
                            <input class="form-control" type="text" value="<?php echo $planta->descricao ?>"
                                   name="descricao" placeholder="descricao"
                                   required="">
                            Latitude
                            <input class="form-control" type="text" value="<?php echo $planta->latitude ?>"
                                   name="latitude" placeholder="latitude"
                                   required="">
                            Longitude
                            <input class="form-control" type="text" value="<?php echo $planta->longitude ?>"
                                   name="longitude" placeholder="longitude"
                                   required="">
                        </div>
                        <div class="col-md-4">
                            Editar imagem <input type="checkbox" name="edit_img" value="1"><br>
                            <?php
                            imagemPlanta($planta->img)
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
                            <input id="preview_file" class="form-control" type="file" onchange="previewFile()" name="file">
                            <br>
                            <input type="hidden" name="id" value="<?php echo $planta->id ?>">
                            <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::CADASTRAR_PLANTA?>">
                            <button class="btn btn-warning" value="Cadastrar planta" style="margin-bottom: 10px">
                                <span class="glyphicon glyphicon-edit"></span>
                                Salvar edição
                            </button>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-offset-8">
                            <form action="controller/AppControll.php" method="post">
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
                                                    (ID: <?php echo $planta->id ?>)</h3>
                                                <h5>Ao excluir a planta, ela será deletada permanentemente e removidas
                                                    das
                                                    trilhas as quais foi incluída.</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Cancelar
                                                </button>
                                                <input type="hidden" value="<?php echo $planta->id ?>"
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
                <?php
                }
                ?>
                <span id="txtHint">
                <?php
                $sql = "select * from ejbsm_planta ORDER BY id limit 10";
                $result = $link->query($sql);
                while ($a = mysqli_fetch_object($result)) {
                    ?>
                    <a href='app_editar_planta.php?id=<?php echo $a->id ?>'>
                        <div class="media alert alert-info">
                            <div class="media-left">
                                <?php
                                imagemPlanta($a->img)
                                ?>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $a->nome_popular ?></h4>
                                Espécie: <?php echo $a->especie ?><br>
                                Descrição: <?php echo $a->descricao ?>
                            </div>
                        </div>
                    </a>
                <?php
                }
                ?>
                    </span>
            </div>
        </div>
    </div>
</div>