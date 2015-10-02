<?php
include 'excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("export brahms livro 8.XLS");
?>
<table class='table'>
    <tr>
        <td>Popular</td>
        <td>Genero</td>
        <td>Especie</td>
        <td>Familia</td>
        <td>Origem</td>
    </tr>
    <?
    for ($i = 2; $i <= $data->rowcount($sheet_index = 0); $i++) {
        ?>
        <tr>
            <td>Nao definido</td>
            <td><?=$data->val($i, 3)?></td>
            <td><?=$data->val($i, 3)." ".$data->val($i, 4)?></td>
            <td><?=$data->val($i, 2)?></td>
            <td><?=$data->val($i, 11).", ".$data->val($i, 12).", ".$data->val($i, 13).", ".$data->val($i, 14)?></td>
        </tr>
    <?
        //$sql = "insert into ejbsm_planta(nome_popular, especie, genero, familia, origem) VALUES ('Não definido', '$data->val($i, 3)', '$data->val($i, 3) $data->val($i, 4)', '$data->val($i, 2)', '$data->val($i, 11) $data->val($i, 12) $data->val($i, 13) $data->val($i, 14)')";
        //$link->query($sql)or die(mysqli_error($link));
    }

    echo "</table> Total: " . $data->rowcount($sheet_index = 0);
    ?>
</table>