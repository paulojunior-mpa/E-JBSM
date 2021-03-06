<?php
include 'e-jbsm_cabecalho.php';
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Selecione a trilha</h3>

        <div class="col-md-3">
            <?php include "app_menu.php"; ?>
        </div>
        <div class="col-md-9">
            <div class="alert alert-info">
                Olá, aqui você pode ver as trilhas disponíveis.
            </div>
            <script>
                function showHint() {
                    var x = document.getElementById("trilha");
                    value = x.options[x.selectedIndex].value;
                    window.location = "app_trilha.php?id=" + value;
                }
            </script>
            <p><b>Selecione uma trilha.</b></p>
            <select id="trilha" class="form-control" onchange="showHint()">
                <option value="">Nenhuma</option>
                <?php
                $sql = "select * from ejbsm_trilha";
                $result = $link->query($sql);
                while ($trilha = mysqli_fetch_object($result)) {
                    echo "<option class='form-control' value='$trilha->id'>$trilha->nome</option>";
                }
                ?>
            </select>
            <hr>
            <?php
            if (isset($_GET["id"])) {
                $id_trilha = $_GET["id"];
                $id_trilha_select = $id_trilha;

                $sql  ="select * from ejbsm_trilha where id = $id_trilha";
                $result = $link->query($sql);
                $trilha_info = mysqli_fetch_object($result);
                echo "<h3>Nome da trilha: $trilha_info->nome</h3><h3>Descrição: $trilha_info->descricao</h3>";

                include 'helpers/mapa_trilhas.php';
                $o=0;
                $sql = "select * from ejbsm_associa_planta WHERE id_trilha = $id_trilha";
                $result = $link->query($sql);
                while ($trilha = mysqli_fetch_object($result)) {
                    $o++;
                    $sql = "select * from ejbsm_planta WHERE id = $trilha->id_planta";
                    $result2 = $link->query($sql) or die(mysqli_error($link));
                    $planta = mysqli_fetch_object($result2) or die(mysqli_error($link));
                    ?>
                    <a href='app.php?id=<?php echo  $planta->id ?>'>
                        <div class="media">
                            <div class="media-left">
                                <?php
                                imagemPlanta($planta->img)
                                ?>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo  $planta->nome_popular ?></h4>
                                <label>Espécie: </label><?php echo  $planta->especie ?>
                            </div>
                        </div>
                    </a>
                    <hr>
                <?php
                }
                if($o==0){
                    echo "Nenhuma planta está cadastrada nesta trilha.";
                }
            }
            ?>
        </div>
    </div>