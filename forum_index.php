<?
$permissao = array("administrador", "orientador", "bolsista");
include 'helpers/permitir.php';

$inicio_consulta = 0;
$consulta = "";
$info = "";
if (isset($_GET["inicio_consulta"])) {
    $inicio_consulta = $_GET["inicio_consulta"];
    $consulta = "select * from ejbsm_forum_topico order by id DESC limit 10 offset $inicio_consulta;";

} elseif (isset($_GET["consulta"])) {
    $consulta = $_GET["consulta"];

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
    <? include 'forum_texto.php'; ?>
    <h3>Pesquisas personalizadas de tópicos</h3>
    <? include 'forum_caixa _pesquisa_.php'; ?>
    <?
    $result = $link->query($consulta) or die(mysqli_error($link));
    $cont = 0;
    if ($result) {
        while ($topico = mysqli_fetch_object($result)) {
            $cont += 1;
        }
        ?>
        <h3>Resultados <span class="badge"><? echo $cont; ?></span></h3>
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
                        <?Imagem($topico->login, 40) ?>
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><? echo $topico->assunto ?></h4>
                    <div style="color: green; margin-left: 10px;"><b>
                            ID </b></div><? echo $topico->id ?>.
                    <div style="color: green"><b>Por </b></div>
                    <a href="forum_info.php?info=login&login=<?= $topico->login ?>"><? echo $topico->login ?></a>
                    <div style="color: green"><b>dia </b></div><? echo $topico->data; ?>
                    <div style="color: green"><b>as </b></div><? echo $topico->hora; ?>
                    <div style="color: green"><b>na área </b></div><a
                        href="forum_info.php?info=area&area=<?= $topico->id_area ?>"><? echo $nome_area ?></a>
                    <div style="color: green"><b>e subárea </b></div><a
                        href="forum_info.php?info=subarea&subarea=<?= $topico->id_subarea ?>"><? echo $nome_subarea ?></a>.

                </div>
                <div class="media-right">
                    <a href="forum_topico.php?topico=<?= $topico->id ?>">
                        <button type="button" class="btn btn-info">
                            <span class="glyphicon glyphicon-eye-open"></span>
                            Visualizar
                        </button>
                    </a>
                </div>
            </div>
        <? }
    } ?>
    <nav class="paginacao">
        <ul class="pagination">
            <?php
            if ($inicio_consulta != "" and $inicio_consulta != 0) {
                ?>
                <li><a href="forum_cadastro_topico.php?inicio_consulta=<?= $inicio_consulta - 10 ?>">&laquo;</a>
                </li>
            <?php } ?>
            <li><a href="forum_index.php?inicio_consulta=<?= 0 ?>">1</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?= 10 ?>">2</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?= 20 ?>">3</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?= 30 ?>">4</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?= 40 ?>">5</a></li>
            <li><a href="forum_index.php?inicio_consulta=<?= $inicio_consulta + 10 ?>">&raquo;</a></li>
        </ul>
    </nav>
</div>
