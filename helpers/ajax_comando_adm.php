<?php
include '../connection/Connection.php';

// get the q parameter from URL
$q = htmlspecialchars($_REQUEST["q"]);

$hint = "";
// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    echo "<h5>SQL: $q</h5>";
    $result = $link->query($q) or die (mysqli_error($link));
    $afetadas = mysqli_affected_rows($link);
    echo "<h5>Linhas afetadas: $afetadas</h5>";
    ?>
    <div class="table-responsive" style="max-height: 400px">
        <table class="table table-responsive" style="max-height: 400px">
            <?
            while ($linha = mysqli_fetch_row($result)) {
                echo "<tr>";
                foreach ($linha as $row) {
                    echo "<td>$row</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
<?
}
?>