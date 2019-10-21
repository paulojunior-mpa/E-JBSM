<?
isUserInRole(array("administrador", "orientador", "bolsista"), false);
include 'e-jbsm_cabecalho.php';
$inicio_consulta = "";
$info = "";
if (isset($_GET["inicio_consulta"])) {
    $inicio_consulta = $_GET["inicio_consulta"];
}
if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Cadastro de plantas</h3>

        <div class="col-md-3">
            <?php include "app_menu.php"; ?>
        </div>
        <div class="col-md-9">
            <?php if ($info == "cadastrada") {
                echo '<div class="alert alert-success"> <span class="glyphicon glyphicon-saved"></span> Planta cadastrada! </div>';
            }
            ?>
            <h4>Cadastro manual</h4>

            <form action="controller/AppControll.php" enctype="multipart/form-data" method="post">
                <div class="row">
                    <div class="col-md-4">
                        Nome popular
                        <input class="form-control" type="text" name="popular" placeholder="popular" required="">
                        Gênero
                        <input class="form-control" type="text" name="gênero" placeholder="gênero" required="">
                        Espécie
                        <input class="form-control" type="text" name="espécie" placeholder="espécie" required="">
                        Família
                        <input class="form-control" type="text" name="família" placeholder="família" required="">
                    </div>
                    <div class="col-md-4">
                        Origem
                        <input class="form-control" type="text" name="origem" placeholder="origem" required="">
                        Exótica
                        <select name="exotica" class="form-control">
                            <option value="sim">SIM</option>
                            <option value="não">NÃO</option>
                        </select>
                        Descrição
                        <input class="form-control" type="text" name="descricao" placeholder="descricao"
                               required="">
                    </div>
                    <div class="col-md-4">
                        Latitude
                        <input class="form-control" type="text" name="latitude" placeholder="latitude" required="">
                        Longitude
                        <input class="form-control" type="text" name="longitude" placeholder="longitude"
                               required="">
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
                        Imagem (máximo 2mb)
                        <img id="imagem_preview" src="" height="120">
                        <input id="preview_file" class="form-control" type="file" onchange="previewFile()" name="file">
                        <br>
                        <input type="hidden" name="opcao" id="opcao" value="<?=Constantes::CADASTRAR_PLANTA?>">
                        <button class="btn btn-success btn-block" value="Cadastrar planta">
                            <span class="glyphicon glyphicon-save"></span>
                            Cadastrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-9 col-md-offset-3">
            <h4>Importar dados de arquivo XLS</h4>

            <form class="form-inline" action="app_cadastro_planta.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputEmail2">
                        <input type="file" class="form-control" name="file">
                        <input type="hidden" name="xls">
                    </label>
                    <button class="btn btn-success" id="exampleInputEmail2" name="opcao" value="Importar plantas">
                        <span class="glyphicon glyphicon-open-file"></span>
                        Importar
                    </button>
                </div>
            </form>
        </div>
        <?
        if (isset($_POST["xls"])) {
            include 'helpers/excel_reader/excel_reader2.php';
            $arquivo = $_FILES["file"]["tmp_name"];
            $data = new Spreadsheet_Excel_Reader($arquivo);
            ?>
            <div class="col-md-offset-3">
                <table class='table'>
                    <tr>
                        <th>Nome popular</th>
                        <th>Genero</th>
                        <th>Especie</th>
                        <th>Familia</th>
                        <th>Origem</th>
                        <th>Descrição</th>
                    </tr>
                    <?
                    $j = 0;
                    for ($i = 0; $i <= $data->rowcount($sheet_index = 0); $i++) {
                        if (!$data->val($i, 2) == "") {
                            $j++;
                            $nome = $data->val($i, 3);
                            $genero = "gênero";
                            $especie = $data->val($i, 1);
                            $familia = $data->val($i, 2);
                            $origen = $data->val($i, 4);
                            $descricao = $data->val($i, 5);
                            ?>
                            <tr>
                                <td><?= $nome ?></td>
                                <td><?= $genero ?></td>
                                <td><?= $especie ?></td>
                                <td><?= $familia ?></td>
                                <td><?= $origen ?></td>
                                <td><?= $descricao ?></td>
                            </tr>
                            <?
                            $sql = "insert into ejbsm_planta(nome_popular, genero, especie, familia, origem, descricao) VALUES ('$nome', '$genero', '$especie', '$familia', '$origen', '$descricao')";
                            $link->query($sql) or die(mysqli_error($link));
                        }
                    }
                    echo "</table> Total: " . $j;
                    ?>
                </table>
            </div>
            <?
        }
        ?>
    </div>
</div>