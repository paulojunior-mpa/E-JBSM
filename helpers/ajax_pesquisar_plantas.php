<?php

// get the q parameter from URL
$q = htmlspecialchars($_REQUEST["q"]);

$hint = "";

$j = 0;
// lookup all hints from array if $q is different from ""
if ($q !== null) {
    if ($q == "")
        $sql = "select * from ejbsm_planta limit 10";
    else
        $sql = "select * from ejbsm_planta where nome_popular LIKE '%$q%' or especie LIKE '%$q%' or descricao LIKE '%$q%' limit 10";
    $result = $link->query($sql);
    while ($a = mysqli_fetch_object($result)) {
        ?>
        <a href='app.php?id=<?php echo $a->id ?>'>
            <div class="media alert alert-info">
                <div class="media-left">
                    <?
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
        <?
        $j++;
    }
}
if ($j == 0)
// Output "no suggestion" if no hint was found or output correct values
    echo $hint === "" ? "Sem resultados para '$q'" : $hint;

?>