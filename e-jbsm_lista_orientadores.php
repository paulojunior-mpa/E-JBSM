<?
isUserInRole(array("administrador", "orientador", "bolsista"));
;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="alert alert-info">
            Tabela de orientadores.
        </div>
        <h3>Lista de orientadores</h3>
        <table class="table table-hover">
            <tr>
                <td><b>Imagem</b></td>
                <td><b>Nome</b></td>
                <td><b>SIAPE</b></td>
                <td><b>Login</b></td>
                <td><b>E-mail</b></td>
                <td><b>Mais</b></td>
            </tr>
            <?
            $sql = "select * from ejbsm_usuario, ejbsm_integrante where permissao = 'orientador' and ejbsm_usuario.login=ejbsm_integrante.login";
            $qr = $link->query($sql);
            while ($r = mysqli_fetch_object($qr)) {
                ?>
                <tr>
                    <td>
                        <?
                        if ($r->status == 0) {
                            echo "<div style='box-shadow: 1px 1px 5px 1px #c9302c;'>";
                        } else {
                            echo "<div>";
                        }
                        imagem($r->login, 80);
                        ?>
                    </td>
                    <td><?php echo "{$r->nome}"; ?></td>
                    <td><?php echo "{$r->id}"; ?></td>
                    <td><?php echo "{$r->login}"; ?></td>
                    <td><?php echo "{$r->email}"; ?></td>
                    <td class="active"><a href="forum_info.php?info=login&login=<?php echo $r->login ?>">Mais</a></td>
                </tr>
            <?
            }
            ?>
        </table>
    </div>
</div>