<?
$permissao = array("administrador", "orientador", "bolsista");
include 'functions/permitir.php';

if (isset($_GET["addmonitor"])) {
    $login_monitor = $_GET["addmonitor"];
    $sql = "update ejbsm_integrante set monitor='sim' where login = '$login_monitor'";
    $link->query($sql) or die(mysqli_error($link));
} elseif (isset($_GET["removemonitor"])) {
    $login_monitor = $_GET["removemonitor"];
    $sql = "update ejbsm_integrante set monitor='nao' where login = '$login_monitor'";
    $link->query($sql) or die(mysqli_error($link));
}
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="list-group">
            <a class="list-group-item badge">
                Integrantes / <font color="blue">Monitores</font>
            </a>
            <?
            $sql = "select * from ejbsm_usuario, ejbsm_integrante where permissao != 'usuario' and status != 'Inativo' and ejbsm_integrante.login=ejbsm_usuario.login";
            $result = $link->query($sql) or die(mysqli_error($link));
            while ($row = mysqli_fetch_object($result) or die(mysqli_error($link))) {
                if ($row->monitor == "sim")
                    echo "<a href='e-jbsm_monitores.php?removemonitor=$row->login' class='list-group-item active'><span>Nome:</span> $row->nome <span>Permissão:</span> $row->permissao <span>Login:</span> $row->login</a>";
                else
                    echo "<a href='e-jbsm_monitores.php?addmonitor=$row->login' class='list-group-item'><span>Nome:</span> $row->nome <span>Permissão:</span> $row->permissao <span>Login:</span> $row->login</a>";
            }
            ?>
        </div>
    </div>
</div>