<?
isUserInRole(array("administrador", "orientador", "bolsista"));
;

$inicio_consulta = 0;
$consulta = "";
$info = "";
if (isset($_GET["inicio_consulta"])) {
    $inicio_consulta = $_GET["inicio_consulta"];
    $consulta = "select * from ejbsm_forum_topico order by id DESC limit 10 offset $inicio_consulta;";
} elseif (isset($_POST["consulta"])) {
    $user_login = $_SESSION["user_login"];
    $user_permissao = $_SESSION["user_permissao"];

    $pesquisa_area = htmlspecialchars($_POST["pesquisa_area"]);
    $pesquisa_subarea = htmlspecialchars($_POST["pesquisa_subarea"]);
    $pesquisa_nome = htmlspecialchars($_POST["pesquisa_nomeUser"]);
    $pesquisa_assunto = htmlspecialchars($_POST["pesquisa_assunto"]);
    $pesquisa_conteudo = htmlspecialchars($_POST["pesquisa_conteudo"]);
    $pesquisa_data = htmlspecialchars($_POST["pesquisa_data"]);

    $consulta = "select * from ejbsm_forum_topico where id > 0";
    if ($pesquisa_area != "") {
        $consulta .= " and id_area like '$pesquisa_area'";
    }
    if ($pesquisa_subarea != "") {
        $consulta .= " and id_subarea like '$pesquisa_subarea'";
    }
    if ($pesquisa_nome != "") {
        $consulta .= " and login like '%$pesquisa_nome%'";
    }
    if ($pesquisa_assunto != "") {
        $consulta .= " and assunto like '%$pesquisa_assunto%'";
    }
    if ($pesquisa_conteudo != "") {
        $consulta .= " and msg like '%$pesquisa_conteudo%'";
    }
    if ($pesquisa_data != "") {
        $consulta .= " and data like '$pesquisa_data'";
    }
    $consulta .= " order by id desc";
} elseif (isset ($_GET["subarea"])) {
    $sub_area = $_GET["subarea"];
    $consulta = "select * from ejbsm_forum_topico where id_subarea = '$sub_area' order by id DESC limit 10 offset $inicio_consulta;";

} else {
    $consulta = "select * from ejbsm_forum_topico order by id DESC limit 10 offset $inicio_consulta;";

}

if (isset($_GET["info"])) {
    $info = $_GET["info"];
}
?>
<div class="panel-body">
    <?php include 'forum_texto.php'; ?>
    <h3>Pesquisas personalizadas de tópicos</h3>
    <?php include 'forum_caixa _pesquisa_.php'; ?>
    <?
    $result = $link->query($consulta) or die(mysqli_error($link));
    $cont = 0;
    if ($result) {
        while ($topico = mysqli_fetch_object($result)) {
            $cont += 1;
        }
        ?>
        <h3>Resultados <span class="badge"><?php echo $cont; ?></span></h3>
        <?
        if ($info == "topico_deletado") {
            ?>
            <div class="alert alert-warning" role="alert">
                Seu tópico foi deletado
            </div>
        <?
        }
        $result = $link->query($consulta);
        while ($topico = mysqli_fetch_object($result)) {
            $sql = "select nome from ejbsm_forum_area where id = $topico->id_area";
            $pega_nome = mysqli_fetch_object($link->query($sql));
            $nome_area = $pega_nome->nome;
            $sql = "select nome from ejbsm_forum_subarea where id = $topico->id_subarea";
            $pega_nome = mysqli_fetch_object($link->query($sql));
            $nome_subarea = $pega_nome->nome;
            ?>
            <div class="alert alert-info">
                <div class="media-left">
                    <a href="#">
                        <?imagem($topico->login, 40);?>
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $topico->assunto ?></h4>
                    <span style="color: green; margin-left: 10px;"><b> ID </b></span><?php echo $topico->id ?>.
                    <span style="color: green"><b>Por </b></span>
                    <a href="forum_info.php?info=login&login=<?php echo $topico->login ?>"><?php echo $topico->login ?></a>
                    <span style="color: green"><b>dia </b></span><?php echo $topico->data; ?>
                    <span style="color: green"><b>as </b></span><?php echo $topico->hora; ?>
                    <span style="color: green"><b>na área </b></span><a href="forum_info.php?info=area&area=<?php echo $topico->id_area ?>"><?php echo $nome_area ?></a>
                    <span style="color: green"><b>e subárea </b></span><a href="forum_info.php?info=subarea&subarea=<?php echo $topico->id_subarea ?>"><?php echo $nome_subarea ?></a>.
                </div>
                <div class="media-right">
                    <a href="forum_topico.php?topico=<?php echo $topico->id ?>">
                        <button type="button" class="btn btn-info">
                            <span class="glyphicon glyphicon-eye-open"></span>
                            Visualizar
                        </button>
                    </a>
                </div>
            </div>
        <?php }
    } ?>
    <nav class="paginacao">
        <ul class="pagination">
            <?php
            if ($inicio_consulta != "" and $inicio_consulta != 0) {
                ?>
                <li><a href="forum_cadastro_topico.php?inicio_consulta=<?php echo $inicio_consulta - 10 ?>">&laquo;</a>
                </li>
            <?php } ?>
            <li><a href="forum_index.php?inicio_consulta=<?php echo 0 ?>">1</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?php echo 10 ?>">2</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?php echo 20 ?>">3</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?php echo 30 ?>">4</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?php echo 40 ?>">5</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?php echo $inicio_consulta + 10 ?>">&raquo;</a></li>
        </ul>
    </nav>
</div>
