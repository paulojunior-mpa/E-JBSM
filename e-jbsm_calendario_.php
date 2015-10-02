<h4>Clique em uma data para vizualizar as visitas.</h4>
<table style="margin-left: 10%; width: 100%">
    <tr>
        <td style="width: 20%">
            <div style="width: 20px; height: 20px; background: #cddcd5; float: left"></div>
            Dia atual.
        </td>
        <td>
            <div style="width: 20px; height: 20px; background: #ccff00; float: left"></div>
            Dia com visita agendada.
        </td>
    </tr>
</table>
<?php
function MostreSemanas()
{
    $semanas = "DSTQQSS";

    for ($i = 0; $i < 7; $i++)
        if ($i == 0 or $i == 6) {
            echo "<td><div style='text-align: center'>" . "<b><font color='red'>" . $semanas{$i} . "</font></b>" . "</div></td>";
        } else {
            echo "<td><b><div style='text-align: center'>" . $semanas{$i} . "</div></b></td>";
        }
}

function GetNumeroDias($mes)
{
    $numero_dias = array(
        '01' => 31, '02' => 28, '03' => 31, '04' => 30, '05' => 31, '06' => 30,
        '07' => 31, '08' => 31, '09' => 30, '10' => 31, '11' => 30, '12' => 31
    );

    if (((date('Y') % 4) == 0 and (date('Y') % 100) != 0) or (date('Y') % 400) == 0) {
        $numero_dias['02'] = 29;    // altera o numero de dias de fevereiro se o ano for bissexto
    }

    return $numero_dias[$mes];
}

function GetNomeMes($mes)
{
    $meses = array('01' => "Janeiro", '02' => "Fevereiro", '03' => "Março",
        '04' => "Abril", '05' => "Maio", '06' => "Junho",
        '07' => "Julho", '08' => "Agosto", '09' => "Setembro",
        '10' => "Outubro", '11' => "Novembro", '12' => "Dezembro"
    );

    if ($mes >= 01 && $mes <= 12)
        return $meses[$mes];

    return "Mês deconhecido";

}

function MostreCalendario($mes, $link)
{

    $numero_dias = GetNumeroDias($mes);    // retorna o número de dias que tem o mês desejado
    $nome_mes = GetNomeMes($mes);
    $diacorrente = 0;

    $diasemana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes, "01", date('Y')), 0);    // função que descobre o dia da semana

    echo "<table class='table-bordered'>";
    echo "<tr>";
    echo "<td colspan = 5><h3 style='margin-left: 10%;'>" . $nome_mes . "</h3></td>";
    echo "</tr>";
    echo "<tr>";
    MostreSemanas();    // função que mostra as semanas
    echo "</tr>";
    for ($linha = 0; $linha < 6; $linha++) {


        echo "<tr>";

        for ($coluna = 0; $coluna < 7; $coluna++) {
            echo "<td width = 30 height = 10 ";
            if
            (($diacorrente == (date('d') - 1) && date('m') == $mes)
            ) {
                echo " style='background:#cddcd5;' ";
            } else {
                if (($diacorrente + 1) <= $numero_dias) {
                    if ($coluna < $diasemana && $linha == 0) {
                        echo " id = 'dia_branco' ";
                    } else {
                        echo " id = 'dia_comum' ";
                    }
                } else {
                    echo " ";
                }
            }
            // pega visitas
            $data = date('y/m/d');
            $partes = explode('/', $data);
            $ano = "20" . $partes[0];
            $dia = $diacorrente + 1;
            $data = $ano . "/" . $mes . "/" . $dia;
            $sql = "select data from ejbsm_visita WHERE data = '$data' AND status = 'Confirmada'";
            $result = $link->query($sql) or die(mysql_error());
            while ($row = mysqli_fetch_object($result)) {
                echo "style='background: #ccff00;'";
            }
            echo " align = 'center'>";

            /* TRECHO IMPORTANTE: A PARTIR DESTE TRECHO É MOSTRADO UM DIA DO CALENDÁRIO (MUITA ATENÇÃO NA HORA DA MANUTENÇÃO) */

            if ($diacorrente + 1 <= $numero_dias) {
                if ($coluna < $diasemana && $linha == 0) {
                    echo " ";
                } else {
                    // echo "<input type = 'button' id = 'dia_comum' name = 'dia".($diacorrente+1)."'  value = '".++$diacorrente."' onclick = "acao(this.value)">";
                    echo "<font size='2'><a href = " . $_SERVER["PHP_SELF"] . "?data=$data>" . ++$diacorrente . "</a></font>";

                }
            } else {
                break;
            }

            /* FIM DO TRECHO MUITO IMPORTANTE */


            echo "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}

function MostreCalendarioCompleto($link)
{
    echo "<table>";
    $cont = 1;
    for ($j = 0; $j < 4; $j++) {
        echo "<tr'>";
        for ($i = 0; $i < 3; $i++) {

            if ($j == 0) {
                echo "<td style='border-right: 1px solid #000000; border-bottom: 1px solid #000000';>";
            } else {
                echo "<td style='border-right: 1px solid #000000;'>";
            }
            MostreCalendario(($cont < 10) ? "0" . $cont : $cont, $link);

            $cont++;
            echo "</td>";

        }
        echo "</tr>";
    }
    echo "</table>";
}

//$mes_atual = date('m');
//MostreCalendario($mes_atual);
echo "<br/>";
MostreCalendarioCompleto($link);
?>