<style>
    #forum_texto_caixa {
        background-image: url(arquivos_imagem_sistema/fundo.png);
        height: 150px;
        border-radius: 4px;
    }

    #forum_texto_imagem {
        width: 20%;
        height: 150px;
        float: left;
    }

    #forum_texto_texto {
        width: 80%;
        height: 150px;
        float: left;
        margin-top: 10px;
        padding-right: 10px;
        font-weight: bold;
        text-align: justify;
        hyphens: auto;
    }
</style>
<div id="forum_texto_caixa">
    <div id="forum_texto_imagem">
        <?
        list($largura, $altura) = getimagesize("arquivos_imagem_sistema/logo.png");
        $max = 80;
        $x = ($altura * $max) / $largura;
        echo "<img src='arquivos_imagem_sistema/logo.png' style='margin-left: 10px; margin-top: 10px;' width='$max' height='$x'>";
        ?>
    </div>
    <div id="forum_texto_texto">
        <div style="color: white">
            <?
            if (isset ($_GET["subarea"])) {
                $id_subarea = $_GET["subarea"];
                $sql = "select * from ejbsm_forum_subarea WHERE id = '$id_subarea'";
                $result = $link->query($sql);
                $subarea = mysqli_fetch_object($result);

                $sql = "select * from ejbsm_forum_area WHERE id = '$subarea->id_area'";
                $result = $link->query($sql);
                $area = mysqli_fetch_object($result);
                ?>
                Área: <?= $area->nome ?><br>
                Descrição: <?= $area->descricao ?><br>
                Subárea: <?= $subarea->nome ?><br>
                Descrição: <?= $subarea->descricao ?>
            <?
            } else {
                echo "Fórum do Jardim Botânico da Universidade Federal de Santa Maria.<br> Local destinado a troca de informações entre JBSM e comunidade.";
            }
            ?>
        </div>
    </div>
</div>