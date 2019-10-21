<?php

// get the q parameter from URL
$q = htmlspecialchars($_REQUEST["q"]);

$j = 0;
if ($q !== "") {
    $sql = "select * from ejbsm_associa_planta WHERE id_trilha = $q";
    $result = $link->query($sql) or die(mysqli_error($link));
    $id_trilha_select=$q;
    while ($trilha = mysqli_fetch_object($result)) {
        $j++;
        $sql = "select * from ejbsm_planta WHERE id = $trilha->id_planta";
        $result2 = $link->query($sql) or die(mysqli_error($link));
        $planta = mysqli_fetch_object($result2) or die(mysqli_error($link));
        ?>
        <a href='app.php?id=<?php echo $planta->id ?>'>
            <div class="media">
                <div class="media-left">
                    <?php
                    imagemPlanta($planta->img)
                    ?>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $planta->nome_popular ?></h4>
                    <label>Nome científico: </label><?echo $planta->nome_cientifico ?>
                </div>
            </div>
        </a>
        <hr>
    <?php
    }
}
if ($j == 0)
// Output "no suggestion" if no hint was found or output correct values
    echo "Nenhuma planta nesta trilha";
?>