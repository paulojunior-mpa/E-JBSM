<?
$permissao = array("administrador", "orientador", "bolsista");
include 'helpers/permitir.php';
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
                        if ($r->status == "Inativo") {
                            echo "<div style='box-shadow: 1px 1px 5px 1px #c9302c;'>";
                        } else {
                            echo "<div>";
                        }
                        Imagem($r->login, 80);
                        ?>
                    </td>
                    <td><? echo "{$r->nome}"; ?></td>
                    <td><? echo "{$r->id}"; ?></td>
                    <td><? echo "{$r->login}"; ?></td>
                    <td><? echo "{$r->email}"; ?></td>
                    <td class="active"><a href="forum_info.php?info=login&login=<?= $r->login ?>">Mais</a></td>
                </tr>
            <?
            }
            ?>
        </table>
    </div>
</div>