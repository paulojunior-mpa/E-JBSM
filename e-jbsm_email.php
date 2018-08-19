<?
isUserInRole(array("administrador", "orientador", "bolsista"));
;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h3>E-mail's que cadastraram visitas.</h3>
        <?
        $sql = "select email from ejbsm_usuario WHERE login in(select login from ejbsm_visita)";
        $result = $link->query($sql) or die(mysqli_error($link));
        while($row = mysqli_fetch_object($result)){
            echo "$row->email<br>";
        }
        ?>
    </div>
</div>