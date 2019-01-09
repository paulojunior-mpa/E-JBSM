<?php

// get the q parameter from URL
$q = $_REQUEST["q"];
$j=0;
$hint = "";

// lookup all hints from array if $q is different from ""
if($q==""){
    $sql = "select * from ejbsm_usuario limit 10";
    getUsuarios($sql, $link);
}
else{
    $sql = "select * from ejbsm_usuario where nome LIKE '%$q%' or login LIKE '%$q%'  or email LIKE '%$q%' limit 10";
    getUsuarios($sql, $link);
}
if ($j == 0)
    echo $hint === "" ? "Sem resultados para '$q'" : $hint;
function getUsuarios($sql, $link)
{
    $contagem = mysqli_num_rows($link->query($sql));
    ?>
    <h4><?= $contagem ?> resultados</h4>
    <table class="table table-hover">
        <tr>
            <td><b>Imagem</b</td>
            <td><b>Nome</b></td>
            <td><b>Login</b></td>
            <td><b>Celular</b></td>
            <td><b>E-mail</b></td>
            <td><b>Mais detalhes</b></td>
        </tr>
        <?
        $qr = $link->query($sql) or die(mysqli_error($link));
        $j = 0;
        while ($r = mysqli_fetch_object($qr)) {
            ?>
            <tr>
                <td>
                    <?imagem($r->login, 80) ?>
                </td>
                <td><? echo "{$r->nome}"; ?></td>
                <td><? echo "{$r->login}"; ?></td>
                <td><? echo "{$r->celular}"; ?></td>
                <td><? echo "{$r->email}"; ?></td>
                <td class="active"><a href="forum_info.php?info=login&login=<?= $r->login ?>">Mais</a></td>
            </tr>
            <?
            $j++;
        }
        ?>
    </table>
<?
}
?>