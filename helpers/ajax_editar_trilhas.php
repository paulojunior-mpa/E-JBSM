<?php

// get the q parameter from URL
$q = $_REQUEST["q"];

$trilha_id = $_REQUEST["trilha_id"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $sql = "select * from ejbsm_planta where nome_popular LIKE '%$q%' or ejbsm_planta.especie LIKE '%$q%' limit 10";
    $result = $link->query($sql);
    $j = 0;
    while ($a = mysqli_fetch_object($result)) {
        ?>
        <div class="media alert alert-info">
            <div class="media-left">
                <?php
                imagemPlanta($a->img)
                ?>
            </div>
            <div class="media-body">
                <a href="app.php?id=<?php echo $a->id?>">
                    <h4 class="media-heading"><?php echo $a->nome_popular ?></h4>
                    Espécie: <?php echo $a->especie ?><br>
                </a>
            </div>
            <div class="media-right">
                <a href="app_editar_trilha.php?trilha_id=<?php echo $trilha_id ?>&addplanta=<?php echo $a->id ?>#trilha">
                    <button class="btn btn-success" style="min-width: 0">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </a>
            </div>
        </div>
        <?php
        $j++;
    }
}
if ($j == 0)
// Output "no suggestion" if no hint was found or output correct values
    echo $hint === "" ? "Sem resultados para '$q'" : $hint;

?>