<?php
include '../DBConnection/Conexao.php';

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
        <a href='app.php?id=<?= $a->id ?>'>
            <div class="media alert alert-info">
                <div class="media-left">
                    <?
                    if ($a->img != "") {
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
        $j++;
    }
}
if ($j == 0)
// Output "no suggestion" if no hint was found or output correct values
    echo $hint === "" ? "Sem resultados para '$q'" : $hint;

?>