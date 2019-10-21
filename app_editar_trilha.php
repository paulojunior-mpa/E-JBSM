<?php
isUserInRole(array("administrador", "orientador", "bolsista"), false);
include 'e-jbsm_cabecalho.php';

$info = "";
if (isset($_GET["info"]))
    $info = $_GET["info"];

?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Editar trilha</h3>

        <div class="row">
            <div class="col-md-3">
                <?php include "app_menu.php"; ?>
            </div>
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
            <div class="col-md-9">
                <h3>Selecione a trilha para editar</h3>
                <script>
                    function MostraTrilha() {
                        var x = document.getElementById("seleciona_trilha");
                        value = x.options[x.selectedIndex].value;
                        window.location = "app_editar_trilha.php?trilha_id=" + value;
                    }
                </script>
                <select id="seleciona_trilha" class="form-control" onchange="MostraTrilha()">
                    <option value="">Nenhuma</option>
                    <?php
                    $sql = "select * from ejbsm_trilha";
                    $result = $link->query($sql);
                    while ($trilha = mysqli_fetch_object($result)) {
                        echo "<option class='form-control' value='$trilha->id'>$trilha->nome</option>";
                    }
                    ?>
                </select>
            </div>
            <?php
            if (isset($_GET["trilha_id"])) { ?>
                <div class="col-md-9">
                    <?php
                    $trilha_id = $_GET["trilha_id"];
                    $sql = "select * from ejbsm_trilha WHERE id = $trilha_id";
                    $result = $link->query($sql) or die(mysqli_error($link));
                    $trilha = mysqli_fetch_object($result);
                    ?>
                    <div class="row">
                        <div class="col-md-8">
                            <?php
                            if ($info == "editada") {
                                echo "<div class='alert alert-info'><span class='glyphicon glyphicon-saved'></span>Alterarções salvas</div>";
                            }
                            ?>
                        </div>
                        <div class="col-md-12" id="trilha">
                            <form action="controller/AppControll.php" method="post">
                                <h4>Trilha <input type="text" class="form-control" name="nome"
                                                  value="<?php echo  $trilha->nome ?>"></h4><h5>Descrição:
                                    <textarea class="form-control" name="descricao"><?php echo  $trilha->descricao ?></textarea>
                                </h5>
                                <input type="hidden" name="id" value="<?php echo  $trilha->id ?>">
                                <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::CADASTRAR_TRILHA?>">
                                <button type="submit" value="Cadastrar trilha" class="btn btn-success">
                                    <span class="glyphicon glyphicon-save"></span>
                                    Salvar
                                </button>
                            </form>
                            <div class="col-md-offset-3">
                                <form action="controller/AppControll.php" method="post">
                                    <button type="button" class="btn btn-danger"
                                            data-toggle="modal"
                                            data-target="#myModal">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        Deletar trilha
                                    </button>
                                    <div class="modal fade" id="myModal" tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="myModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Confirmar exclusão.
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <h3>Deseja mesmo excluir esta trilha?
                                                        (ID: <?php echo  $trilha_id ?>)</h3>
                                                    <h5>Ao excluir a trilha, as plantas permanecerão.</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Cancelar
                                                    </button>
                                                    <input type="hidden" value="<?php echo  $trilha_id ?>" name="id">
                                                    <input type="hidden" name="opcao" id="opcao" value="<?php echo Constantes::DELETAR_TRILHA?>">
                                                    <button type="submit" value="Deletar trilha" class="btn btn-danger">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                        Deletar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <h4>Adicione ou remova plantas à trilha.</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-3">
                    <?php
                    //ADD NOVA PLANTA
                    if (isset($_GET["addplanta"])) {
                        $nova_planta = $_GET["addplanta"];
                        $sql = "select * from ejbsm_associa_planta where id_planta = $nova_planta AND id_trilha = $trilha_id";
                        $result = $link->query($sql);
                        if (!$associacao = mysqli_fetch_object($result)) {
                            $sql = "insert into ejbsm_associa_planta(id_planta, id_trilha) VALUES('$nova_planta', '$trilha_id')";
                            $link->query($sql);
                        }
                    }//REMOVE PLANTA
                    elseif (isset($_GET["remplanta"])) {
                        $antiga_planta = $_GET["remplanta"];
                        $sql = "delete from ejbsm_associa_planta where id_planta = $antiga_planta AND id_trilha = $trilha_id";
                        $link->query($sql) or die(mysqli_error($link));
                    }
                    //PLANTAS DA TRILHA
                    $sql = "select * from ejbsm_associa_planta WHERE id_trilha = $trilha_id";
                    $result = $link->query($sql) or die(mysqli_error($link));
                    while ($trilha = mysqli_fetch_object($result)) {
                        $sql = "select * from ejbsm_planta WHERE id = $trilha->id_planta";
                        $result2 = $link->query($sql) or die(mysqli_error($link));
                        $planta = mysqli_fetch_object($result2) or die(mysqli_error($link));
                        ?>
                        <div class="media alert alert-info">
                            <div class="media-left">
                                <?php
                                imagemPlanta($planta->img)
                                ?>
                            </div>
                            <div class="media-body">
                                <a href="app.php?id=<?php echo  $planta->id ?>">
                                    <h4 class="media-heading"><?php echo  $planta->nome_popular ?></h4>
                                    <label>Espécie: </label><?php echo  $planta->especie ?>
                                </a>
                            </div>
                            <div class="media-right">
                                <a href="app_editar_trilha.php?trilha_id=<?php echo  $trilha_id ?>&remplanta=<?php echo  $planta->id ?>#trilha">
                                    <button class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-md-4">
                    <h4>Adicionar plantas</h4>
                    <script>
                        function AdicionarPlanta(str) {
                            if (str.length == 0) {
                                document.getElementById("adicionar_plantas").innerHTML = "";
                                return;
                            } else {
                                var xmlhttp = new XMLHttpRequest();
                                xmlhttp.onreadystatechange = function () {
                                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                        document.getElementById("adicionar_plantas").innerHTML = xmlhttp.responseText;
                                    }
                                }
                                var trilha_id = "";
                                xmlhttp.open("GET", "helpers/ajax_editar_trilhas.php?q=" + str + "&trilha_id=" +<?php echo $trilha_id?>, true);
                                xmlhttp.send();
                            }
                        }
                    </script>
                    <p><b>Digite o do nome popular ou espécie para obter resultados:</b></p>
                    <input class="form-control" type="text" onkeyup="AdicionarPlanta(this.value)">
                    <br>
                    <span id="adicionar_plantas"></span>
                </div>
            <?php } ?>
        </div>
    </div>
</div>