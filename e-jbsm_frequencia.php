<?
isUserInRole(array("usuario", "administrador", "orientador", "bolsista"));

if ($user_permissao == "orientador" or $user_permissao == "administrador") {
    $loginBolsista = "";
    if (isset($_POST["login"])) {
        $loginBolsista = $_POST["login"];
    }
    $inicio_consulta = "";
    if (isset($_GET["inicio_consulta"])) {
        $inicio_consulta = $_GET["inicio_consulta"];
    }
    $inicio = "";
    if (isset($_POST["login"])) {
        $inicio = $_POST["inicio"];
    }
    $fim = "";
    if (isset($_POST["login"])) {
        $fim = $_POST["fim"];
    }
    $total = 0;
    $total2 = 0;

    $sql = "SELECT SUM(saida - entrada) as soma from ejbsm_frequencia where login = '$loginBolsista' order by data DeSC;";
    $qr = $link->query($sql) or die($link);
    while ($r = mysqli_fetch_object($qr)) {
        $total = "$r->soma";
    }
    $sql2 = "SELECT SUM(saida - entrada) as soma from ejbsm_frequencia where login = '$loginBolsista' and data >= '$inicio' and data <= '$fim' order by data DeSC;";
    $qr2 = $link->query($sql2) or die($link);
    while ($r2 = mysqli_fetch_object($qr2)) {
        $total2 = "$r2->soma";
    }
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Controle de frequência.</h3>

            <form action="e-jbsm_frequencia.php" method="post">
                <table class="table">
                    <tr>
                        <td>
                            Slecione o bolsista
                            <select name="login" required class="form-control">
                                <?
                                $sql = "select * from ejbsm_usuario where permissao = 'bolsista' and status != 0;";
                                $qr = $link->query($sql);
                                while ($r = mysqli_fetch_object($qr)) {
                                    ?>
                                    <option value="<?= $r->login ?>"><? echo "$r->login / ";
                                        $Pnome = explode(" ", $r->nome);
                                        echo "$Pnome[0]"; ?>
                                    </option>
                                <? } ?>
                            </select>
                        </td>
                        <td>
                            No período de
                            <input type="date" class="form-control" name="inicio" required>
                        </td>
                        <td>
                            até
                            <input type="date" class="form-control" name="fim" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit" class="btn btn-info" value="Verificar" name="opcao">
                                <span class="glyphicon glyphicon-search"></span>
                                Verificar
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
            <?
            if (isset($_POST["login"])) {
                ?>
        <h4>O total de horas de '<? echo "$loginBolsista"; ?>' é de <? echo "$total"; ?> horas.<br>
            No período de <? echo $inicio ?> até <? echo $fim ?> foram <? echo "$total2"; ?> horas.</h4>
        <?
                $sql = "select * from ejbsm_frequencia where login = '$loginBolsista' and data >= '$inicio' and data <= '$fim' order by data DeSC, saida asc;";
                $qr = $link->query($sql);
                while ($r = mysqli_fetch_object($qr)) {
                    ?>
        Data: </b><? echo "{$r->data}"; ?>
        Entrada: </b><? echo "{$r->entrada}"; ?>
        Saída: </b><? echo "{$r->saida}"; ?><br>
        <? }
            } ?>
        </div>
    </div>
<?
}
if ($user_permissao == "bolsista") {
    $sql = "select sum(saida-entrada) as soma from ejbsm_frequencia where login ='$user_login'";
    $total = mysqli_fetch_object($link->query($sql));
    $total_horas = $total->soma;
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Cadastro de Frequência</h3>
            <h4>Seu total de horas é: <? echo "$total_horas"; ?> horas</h4>

            <form action="controller/SystemController.php" method="post">
                <table class="table">
                    <tr>
                        <td>
                            Data
                            <input type="date" class="form-control" name="data" required="">
                        </td>
                        <td>
                            Hora de entrada
                            <input type="time" class="form-control" name="entrada" required="">
                        </td>
                        <td>
                            Hora de saída
                            <input type="time" class="form-control" name="saida" required="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="opcao" id="opcao" value="<?=Constantes::CADASTRAR_FREQUENCIA?>">
                            <button type="submit" class="btn btn-success">
                                Cadastrar
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Lista de horários cadastrados</h3>
            <?
            $inicio_consulta="";
            if(isset($_GET["inicio_consulta"])){
                $inicio_consulta=$_GET["inicio_consulta"];
            }
            if ($inicio_consulta != "" and $inicio_consulta > 0)
                $sql = "select * from ejbsm_frequencia where login = '$user_login' order by data DeSC, saida asc limit 10 offset $inicio_consulta;";

            else
                $sql = "select * from ejbsm_frequencia where login = '$user_login' order by data DeSC, saida asc limit 10;";

            $qr = $link->query($sql);
            $j = 0;
            while ($r = mysqli_fetch_object($qr)) {
                ?>
                <table class="table">
                    <tr>
                        <td><b>ID: </b><?= $r->id ?></td>
                        <td><b>Data: </b><?= $r->data ?></td>
                        <td><b>Entrada: </b><?= $r->entrada ?></td>
                        <td><b>Saída: </b><?= $r->saida ?></td>
                    </tr>
                </table>
            <? } ?>
            <nav>
                <ul class="pagination">
                    <?php
                    if ($inicio_consulta != "" and $inicio_consulta != 0) {
                        ?>
                        <li>
                            <a href="e-jbsm_programacoes.php?inicio_consulta=<?= $inicio_consulta - 10 ?>">&laquo;</a>
                        </li>
                    <?php } ?>
                    <li><a href="e-jbsm_bolsista_frequencia.php?inicio_consulta=<?= 0 ?>">1</a></li>
                    <li><a href="e-jbsm_bolsista_frequencia.php?inicio_consulta=<?= 10 ?>">2</a></li>
                    <li><a href="e-jbsm_bolsista_frequencia.php?inicio_consulta=<?= 20 ?>">3</a></li>
                    <li><a href="e-jbsm_bolsista_frequencia.php?inicio_consulta=<?= 30 ?>">4</a></li>
                    <li><a href="e-jbsm_bolsista_frequencia.php?inicio_consulta=<?= 40 ?>">5</a></li>
                    <li>
                        <a href="e-jbsm_bolsista_frequencia.php?inicio_consulta=<?= $inicio_consulta + 10 ?>">&raquo;</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<? } ?>