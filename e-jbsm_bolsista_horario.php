<?php
$sql = "select login from ejbsm_horario_bolsista where login = '$login_usuario'";
$result = $link->query($sql);
$r = mysqli_fetch_assoc($result);
if($r["login"]==""){
    $sql = "INSERT INTO ejbsm_horario_bolsista (login, seg89, ter89, qua89, qui89, sex89, seg910, ter910, qua910, qui910, sex910, seg1011, ter1011, qua1011, qui1011, sex1011, seg1112, ter1112, qua1112, qui1112, sex1112, seg1314, ter1314, qua1314, qui1314, sex1314, seg1415, ter1415, qua1415, qui1415, sex1415, seg1516, ter1516, qua1516, qui1516, sex1516, seg1617, ter1617, qua1617, qui1617, sex1617) VALUES ('$login_usuario', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');";
    $result = $link->query($sql);
}
echo "<table style='text-align: center; text-align: center; width: 100%'>
        <tr style='width: 100%'>
            <td></td>
            <td style='width: 18%'><div>Seg</div></td>
            <td style='width: 18%'><div>Ter</div></td>
            <td style='width: 18%'><div>Qua</div></td>
            <td style='width: 18%'><div>Qui</div></td>
            <td style='width: 18%'><div>Sex</div></td>
        </tr>";
echo "<tr><td colspan='6' style='text-align: center'><h4>Manhã</h4></td></tr>";
$semana = array("seg", "ter", "qua", "qui", "sex");
$h = 8;
$h2 = 9;
$c_total_horas = 0;
$checado = 0;
for ($i = 0; $i < 8; $i++) {
    echo "<tr>";
    if ($h == 12) {
        $h++;
        $h2++;
        echo "<td colspan='6' style='text-align: center'><h4>Tarde</h4></td></tr><tr>";
    }
    echo "<td><div size='4'>$h:30-$h2:30</div></td>";
    for ($j = 0; $j < 5; $j++) {
        $sql = "select * from ejbsm_horario_bolsista where $semana[$j]$h$h2 = '1' and login = '$login_usuario';";
        $result = $link->query($sql) or die (mysql_error());
        echo "<td style='width: 18%'>";
        while ($r = mysqli_fetch_object($result)) {
            echo "<div style='border: 1px solid #556b2f; background-color: #66cdaa; margin-left: 3px; margin-bottom: 3px;'>";
            $c_total_horas++;
            $checado = 1;
        }
        if ($checado == 1)
            echo "<input type='checkbox' name='$semana[$j]$h$h2' value='1' checked>";
        else
            echo "<input type='checkbox' name='$semana[$j]$h$h2' value='1'>";
        echo "</div></td>";
        $checado=0;
    }
    echo "</tr>";
    $h++;
    $h2++;
}
echo "<tr><td colspan='2'><h4>Total de horas semanais $c_total_horas</h4></td></tr>";
echo "</table>";
?>