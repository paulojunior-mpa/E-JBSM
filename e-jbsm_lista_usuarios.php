<?
$permissao = array("administrador", "orientador", "bolsista");
include 'functions/permitir.php';

$pesquisa = "";
if (isset($_POST["pesquisa"])) {
    $pesquisa = $_POST["pesquisa"];
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>Pesquisa de usuarios</h3>
        <script>
            function showHint(str) {
                if (str.length == 0) {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET", "functions/ajax_pesquisar_usuarios.php?q=" + str, true);
                    xmlhttp.send();
                }
            }
        </script>
        <p><b>Digite o início do nome, login ou e-mail do usuário</b></p>

        <form>
            <input class="form-control" type="text" onkeyup="showHint(this.value)">
        </form>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body" id="usuarios">
        <h3>Lista de usuarios</h3>
        <span id="txtHint">
        <table class="table table-hover">
            <td><b>Imagem</b</td>
            <td><b>Nome</b></td>
            <td><b>Login</b></td>
            <td><b>Celular</b></td>
            <td><b>E-mail</b></td>
            <td><b>Mais detalhes</b></td>
            </tr>
            <?
            $inicio_consulta = "";
            if ($pesquisa != "") {
                $sql = "select * from ejbsm_usuario where permissao = 'usuario' and login like '%$pesquisa%' or nome like '$pesquisa%'";
            } elseif (isset($_GET["inicio_consulta"])) {
                $inicio_consulta = $_GET["inicio_consulta"];
                $sql = "select * from ejbsm_usuario where permissao = 'usuario' order by login limit 10 offset $inicio_consulta";
            } else {
                $sql = "select * from ejbsm_usuario where permissao = 'usuario' order by login limit 10;";
            }
            $qr = $link->query($sql) or die(mysqli_error($link));
            $j = 0;
            while ($r = mysqli_fetch_object($qr)) {
                ?>
                <tr>
                    <td>
                        <?Imagem($r->login, 80) ?>
                    </td>
                    <td><? echo "{$r->nome}"; ?></td>
                    <td><? echo "{$r->login}"; ?></td>
                    <td><? echo "{$r->celular}"; ?></td>
                    <td><? echo "{$r->email}"; ?></td>
                    <td class="active"><a href="forum_info.php?info=login&login=<?= $r->login ?>">Mais</a></td>
                </tr>
            <?
            }
            ?>
        </table>
            </span>
        <nav>
            <ul class="pagination">
                <?php
                if ($inicio_consulta == number_format(0)) {
                    ?>
                    <li>
                        <a href="e-jbsm_lista_usuarios.php?inicio_consulta=<?= $inicio_consulta - 10 ?>#visitas">&laquo;</a>
                    </li>
                <?php } ?>
                <li><a href="e-jbsm_lista_usuarios.php?inicio_consulta=<?= 0 ?>">1</a></li>
                <li><a href="e-jbsm_lista_usuarios.php?inicio_consulta=<?= 10 ?>">2</a></li>
                <li><a href="e-jbsm_lista_usuarios.php?inicio_consulta=<?= 20 ?>">3</a></li>
                <li><a href="e-jbsm_lista_usuarios.php?inicio_consulta=<?= 30 ?>">4</a></li>
                <li><a href="e-jbsm_lista_usuarios.php?inicio_consulta=<?= 40 ?>">5</a></li>
                <li>
                    <a href="e-jbsm_lista_usuarios.php?inicio_consulta=<?= $inicio_consulta + 10 ?>#visitas">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
</div>