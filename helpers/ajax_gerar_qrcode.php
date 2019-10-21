<?php

// get the q parameter from URL
$q = htmlspecialchars($_REQUEST["q"]);
$p = htmlspecialchars($_REQUEST["p"]);

$hint = "";

$j = 0;
// lookup all hints from array if $q is different from ""
if ($q !== null) {
    $sql = "select * from ejbsm_planta where nome_popular LIKE '%$q%' or especie LIKE '%$q%' or descricao LIKE '%$q%' limit 10";
    $result = $link->query($sql);
    while ($a = mysqli_fetch_object($result)) {
        ?>
        <div class="media alert alert-info">
            <div class="media-left">
                <?php
                imagemPlanta($a->img)
                ?>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?php echo $a->nome_popular ?></h4>
                Espécie: <?php echo $a->especie ?><br>
            </div>
            <div class="media-right">
                <a href="app_qrcode.php?id=<?php echo $a->id ?>&p=<?php echo $p?>">
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